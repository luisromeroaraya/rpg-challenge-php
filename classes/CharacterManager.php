<?php
    // DB MANAGER CLASS
    class CharacterManager {
        private $_db; // PDO INSTANCE

        // CONSTRUCTOR
        public function __construct($db) {
            $this->setDb($db);
        }

        // METHODS
        public function setDb(PDO $db) { // links $db to manager
            $this->_db = $db;
        }
        public function count() { // returns quantity $count of characters in the DB
            $request = $this->_db->query(" SELECT COUNT(*) FROM characters ");
            $count = $request->fetchColumn();
            return $count;
        }
        public function exists($info) { // checks if character exists searching for $info, returns boolean
            if (is_int($info)) { // IF $info is an ID
                $request = $this->_db->query(" SELECT COUNT(*) FROM characters WHERE id = '{$info}' "); // prepare request to count matches (1 or 0)
                $count = $request->fetchColumn(); 
                return (bool) $count; // converts 1 or 0 to true or false
            }
            // ELSE $info is a name    
            $request = $this->_db->query(" SELECT COUNT(*) FROM characters WHERE name = '{$info}' "); // prepare request to count matches (1 or 0)
            $count = $request->fetchColumn(); 
            return (bool) $count; // converts 1 or 0 to true or false
        } 
        public function add(Character $character) { // adds $character into DB (the DB puts the default values for id str hp lvl exp)
            $request = $this->_db->prepare(" INSERT INTO characters(name, race, item, strength, health) VALUES(:name, :race, :item, :strength, :health) "); // prepare INSERT request
            $request->bindValue(":name", $character->name(), PDO::PARAM_STR); // PARAM_STR declares that the value is a STRING
            $request->bindValue(":race", $character->race(), PDO::PARAM_STR);
            $request->bindValue(":item", $character->item()->name(), PDO::PARAM_STR);
            $request->bindValue(":strength", $character->strength(), PDO::PARAM_INT); // assign values to the request
            $request->bindValue(":health", $character->health(), PDO::PARAM_INT);
            $request->execute(); // run request
            $character->hydrate(["id" => $this->_db->lastInsertId()]);
        }
        public function delete(Character $character) { // deletes $character from DB
            $this->_db->exec(" DELETE FROM characters WHERE id = {$character->id()} "); // run DELETE request
        }
        public function update(Character $character) { // updates values from $character into the DB
            $request = $this->_db->prepare(" UPDATE characters SET strength = :strength, health = :health, level = :level, experience = :experience WHERE id = :id ");// prepare UPDATE request
            $request->bindValue(":strength", $character->strength(), PDO::PARAM_INT); // assign values to the request
            $request->bindValue(":health", $character->health(), PDO::PARAM_INT);
            $request->bindValue(":level", $character->level(), PDO::PARAM_INT);
            $request->bindValue(":experience", $character->experience(), PDO::PARAM_INT);
            $request->bindValue(":id", $character->id(), PDO::PARAM_INT);
            $request->execute(); // run request
        }
        public function get($info) { // returns a character from DB searching for $info
            if (is_int($info)) { // IF $info is an ID
                $request = $this->_db->query(" SELECT * FROM characters WHERE id = '{$info}' "); // run SELECT WHERE request tu return a Character
                $values = $request->fetch(PDO::FETCH_ASSOC);
                switch ($values['race']) {
                    case 'Human' :
                        return new Human($values);
                        break;
                    case 'Orc' :
                        return new Orc($values);
                        break;
                    case 'Elf' :
                        return new Elf($values);
                        break;
                    case 'Vampire' :
                        return new Vampire($values);
                }
            }
            // ELSE $info is a name
            $request = $this->_db->query(" SELECT * FROM characters WHERE name = '{$info}' ");
            $values = $request->fetch(PDO::FETCH_ASSOC);
            switch ($values['race']) {
                case 'Human' :
                    return new Human($values);
                    break;
                case 'Orc' :
                    return new Orc($values);
                    break;
                case 'Elf' :
                    return new Elf($values);
                    break;
                case 'Vampire' :
                    return new Vampire($values);
            }
        }
        public function getList() { // gets a list of all characters
            $characters = [];
            $request = $this->_db->query(" SELECT * FROM characters ORDER BY name ");
            while($values = $request->fetch(PDO::FETCH_ASSOC)) {
                switch ($values['race']) {
                    case 'Human' :
                        $characters[] = new Human($values);
                        break;
                    case 'Orc' :
                        $characters[] = new Orc($values);
                        break;
                    case 'Elf' :
                        $characters[] = new Elf($values);
                        break;
                    case 'Vampire' :
                        $characters[] = new Vampire($values);
                }
            }
            return $characters; // returns array of Characters   
        }
        public function getEnemies($name) { // gets a list of all characters except $name
            $characters = [];
            $request = $this->_db->query(" SELECT * FROM characters WHERE name <> '{$name}' ORDER BY name ");
            while($values = $request->fetch(PDO::FETCH_ASSOC)) {
                switch ($values['race']) {
                    case 'Human' :
                        $characters[] = new Human($values);
                        break;
                    case 'Orc' :
                        $characters[] = new Orc($values);
                        break;
                    case 'Elf' :
                        $characters[] = new Elf($values);
                        break;
                    case 'Vampire' :
                        $characters[] = new Vampire($values);
                }
            }
            return $characters; // returns array of Characters   
        }
    }