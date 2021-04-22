<?php // MODEL
    require "model/db.php";

    // CREATE LOADCLASS FUNCTION
    function loadClass($class) {
        require "classes/" . $class . ".php";
    }
    spl_autoload_register("loadClass"); // LOADS AUTOMATICALLY THE CLASSES WHEN THEY NEED IT USING THE loadClass function. In our example the classname must be the same as the file.php (ex: class Character is in Character.php)

    require "model/session.php";

    // CREATE MANAGER
    $manager = new CharacterManager($db);

    require "model/formGrabbers.php";
?>
<!-- VIEW -->
<!DOCTYPE html>
<html>
    <?php 
        require "view/head.php"; 
    ?>
    <body>        
        <?php
            if (isset($character)) { // IF there is a character selected we show the Battle Field
                $_SESSION['character'] = $character; // we store the character in the $_SESSION variable
                require "view/battleField.php";
            }
            else { // ELSE we show the Choose Hero screen
                require "view/chooseHero.php";
            }
            require "view/script.php";
        ?>
    </body>
</html>
