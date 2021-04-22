<?php
    // FORM GRABBERS
    if (isset($_POST['create']) AND isset($_POST['heroName']) AND isset($_POST['heroRace']) AND isset($_POST['heroItem'])) { // IF create character button is clicked
        switch ($_POST['heroRace']) {
            case 'Human' :
                $character = new Human(['name'=>$_POST['heroName']]);
                break;
            case 'Orc' :
                $character = new Orc(['name'=>$_POST['heroName']]);
                break;
            case 'Elf' :
                $character = new Elf(['name'=>$_POST['heroName']]);
                break;
            case 'Vampire' :
                $character = new Vampire(['name'=>$_POST['heroName']]);
        }
        $character->setRace($_POST['heroRace']);
        $character->setItem($_POST['heroItem']);
        
        if (empty($character->name())) {
        $message = "You must enter a name.";
        unset($character);
        }
        elseif ($manager->exists($character->name())) {
            $message = "There is already a character with that name. Choose another name.<br>";
            unset($character); // destroys $character variable
        }
        else {
            $manager->add($character);
            $message = "{$character->name()} has been added into the database! <br>";
        }
    }
    elseif (isset($_POST['use']) AND isset($_POST['heroName'])) { // IF use character button is clicked
        if ($manager->exists($_POST['heroName'])) {
            $character = $manager->get($_POST['heroName']);
            $message = "{$character->name()} is ready to fight! <br>";
        }
        else {
            $message = "There is no character with that name. Choose another name.<br>";
        }
    }
    elseif (isset($_GET['hit'])) { // IF hit character button is clicked
        if (!isset($character)) {
            $message = "Please create or choose a character first.";
        }
        elseif (!$manager->exists((int) $_GET['hit'])) {
            $message = "The character you want to hit doesn't exist.";
        }
        else {
            $opponent = $manager->get((int) $_GET['hit']); // we get the opponent by its id value stored in $_GET['hit']
            $return = $character->hit($opponent); // we hit the opponent and we store the result
            switch ($return) {
                case Character::ITS_ME :
                    $message = $message . "You can't hit yourself!<br>";
                    break;
                case Character::CHARACTER_HIT :
                    $message = $message . "{$opponent->name()} has received {$character->damage()} points of damage from {$character->name()}!<br>";
                    $manager->update($character);
                    $manager->update($opponent);
                    break;
                case Character::CHARACTER_KILLED :
                    $message = $message . "You killed {$opponent}!<br>";
                    $manager->update($character);
                    $manager->delete($opponent);
            }
            $return = $opponent->hit($character); // we hit the opponent and we store the result
            switch ($return) {
                case Character::ITS_ME :
                    $message = $message . "You can't hit yourself!<br>";
                    break;
                case Character::CHARACTER_HIT :
                    $message = $message . "{$character->name()} has received {$opponent->damage()} points of damage from {$opponent->name()}!<br>";
                    $manager->update($opponent);
                    $manager->update($character);
                    break;
                case Character::CHARACTER_KILLED :
                    $message = $message . "You killed {$character}!<br>";
                    $manager->update($opponent);
                    $manager->delete($character);
            }
        }
    }