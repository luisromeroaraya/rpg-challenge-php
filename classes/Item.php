<?php
    // CLASS ITEM
    abstract class Item {
        // ATTRIBUTES
        protected $_name;
        protected $_dodge = false;
        protected $_healing = false;
        protected $_damage = 1;
        protected $_twice = false;

        // HYDRATE FUNCTION
        public function hydrate($name) {
            $this->setName($name);
        }

        // CONSTRUCTOR (it must always be public)
        public function __construct($name) {   // this is the object we're working with
            $this->hydrate($name);
        }

        // GETTERS
        public function name() {
            return $this->_name;
        }
        public function dodge() {
            return $this->_dodge;
        }
        public function healing() {
            return $this->_healing;
        }
        public function damage() {
            return $this->_damage;
        }
        public function twice() {
            return $this->_twice;
        }

        // SETTERS (MUTATORS)
        public function setName($name) {
            if (!is_string($name)) {
                trigger_error("Name must be a string.<br>", E_USER_WARNING);
                return;
            }
            $this->_name = $name;
        }
        public function setDodge($dodge) {
            if (!is_bool($dodge)) {
                trigger_error("Dodge must be a boolean.<br>", E_USER_WARNING);
                return;
            }
            $this->_dodge = $dodge;
        }
        public function setHealing($healing) {
            if (!is_bool($healing)) {
                trigger_error("Healing must be a boolean.<br>", E_USER_WARNING);
                return;
            }
            $this->_healing = $healing;
        }
        public function setDamage($damage) {
            $damage = (int)$damage;
            if ($damage < 1 || $damage > 2) {
                trigger_error("Damage must be a number between 1-2.<br>", E_USER_WARNING);
                return;
            }
            $this->_damage = $damage;
        }
        public function setTwice($twice) {
            if (!is_bool($twice)) {
                trigger_error("Twice must be a boolean.<br>", E_USER_WARNING);
                return;
            }
            $this->_twice = $twice;
        }
    }