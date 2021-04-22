<?php
    // OBJECT ORIENTED PROGRAMMING IN PHP
    // https://openclassrooms.com/fr/courses/1665806-programmez-en-oriente-objet-en-php
    
    // CLASS CHARACTER
    abstract class Character {
        // ATTRIBUTES
        protected $_id;
        protected $_name;
        protected $_race;
        protected $_item;
        protected $_strength = 20; // STR strength to attack
        protected $_health = 100; // HP health power
        protected $_level = 1; // LVL
        protected $_experience = 1; // EXP
        protected $_damage;
        protected $_damageTaken = 1;

        // CONSTANTS
        const ITS_ME = 1; // NUMBER SENT IF WE HIT OURSELVES
        const CHARACTER_KILLED = 2; // NUMBER SENT IF WE KILL THE CHARACTER WE HIT
        const CHARACTER_HIT = 3; // NUMBER SENT IF WE HIT THE CHARACTER

        // protected STATIC VARIABLES
        protected static $_text = 'I will kill you ! <br>';

        // HYDRATE FUNCTION
        public function hydrate(array $array) {
            foreach ($array as $key => $value) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }

        // CONSTRUCTOR (it must always be public)
        public function __construct(array $array) {   // this is the object we're working with
            $this->hydrate($array);
        }

        // GETTERS
        public function id() {
            return $this->_id;
        }
        public function name() {
            return $this->_name;
        }
        public function race() {
            return $this->_race;
        }
        public function item() {
            return $this->_item;
        }
        public function strength() {
            return $this->_strength;
        }
        public function health() {
            return $this->_health;
        }
        public function level() {
            return $this->_level;
        }
        public function experience() {
            return $this->_experience;
        }
        public function damage() {
            return $this->_damage;
        }
        public function damageTaken() {
            return $this->_damageTaken;
        }

        // SETTERS (MUTATORS)
        public function setId($id) {
            $id = (int)$id;
            if ($id <= 0) {
                trigger_error("Id must be greater than 0.<br>", E_USER_WARNING);
                return;
            }
            $this->_id = $id;
        }
        public function setName($name) {
            if (!is_string($name)) {
                trigger_error("Name must be a string.<br>", E_USER_WARNING);
                return;
            }
            $this->_name = $name;
        }
        public function setRace($race) {
            if (!is_string($race)) {
                trigger_error("Race must be a string.<br>", E_USER_WARNING);
                return;
            }
            $this->_race = $race;
        }
        public function setItem($item) {
            if (!is_string($item)) {
                trigger_error("Item must be a string.<br>", E_USER_WARNING);
                return;
            }
            switch ($item) {
                case 'Boots' :
                    $this->_item = new Boots($item);
                    break;
                case 'Staff' :
                    $this->_item = new Staff($item);
                    break;
                case 'Sword' :
                    $this->_item = new Sword($item);
                    break;
                case 'Bow' :
                    $this->_item = new Bow($item);
            }
        }
        public function setStrength($strength) {
            $strength = (int)$strength;
            if ($strength < 1 || $strength > 100) {
                trigger_error("Strength must be a number between 1-100.<br>", E_USER_WARNING);
                return;
            }
            $this->_strength = $strength;
        }
        public function setHealth($health) {
            $health = (int)$health;
            if ($health < 1 || $health > 140) {
                trigger_error("Health must be a number between 1-140.<br>", E_USER_WARNING);
                return;
            }
            $this->_health = $health;
        }
        public function setLevel($level) {
            $level = (int)$level;
            if ($level < 1 || $level > 100) {
                trigger_error("Level must be a number between 1-100.<br>", E_USER_WARNING);
                return;
            }
            $this->_level = $level;
        }
        public function setExperience($experience) {
            $experience = (int)$experience;
            if ($experience < 1 || $experience > 100) {
                trigger_error("Experience must be a number between 1-100.<br>", E_USER_WARNING);
                return;
            }
            $this->_experience = $experience;
        }
        public function setDamage($damage) {
            $damage = (int)$damage;
            if ($damage < 1 || $damage > 100) {
                trigger_error("Damage must be a number between 1-100.<br>", E_USER_WARNING);
                return;
            }
            $this->_damage = $damage;
        }

        // METHODS
        public function winExperience() {
            $this->_experience++;
        }
        public function hit(Character $opponent) { // add class name to variable to make sure that it only accepts this kind of variable
            if ($opponent->id() == $this->id()) {
                return self::ITS_ME;
            }
            $damage = floor(mt_rand(1,$this->strength()) * $opponent->damageTaken()); // generates random damage value between 1-STR multiplied by damageTaken factor
            $this->setDamage($damage);
            $this->winExperience();
            return $opponent->receiveDamage($this->damage());
        }
        public function receiveDamage($damage) {
            $this->_health = $this->_health - $damage;
            if (($this->health()) <= 0) {
                return self::CHARACTER_KILLED;
            }
            return self::CHARACTER_HIT;
        }

        // STATIC METHODS (they belong to a class and not to an object so you can't use "this". Instead you can use "self")
        static function talk() {
            echo self::$_text;
        }
    }