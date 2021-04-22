<p><a href="index.php?">Home</a></p>
<?php
    if (isset($message)) { // IF there is a message to show
        echo "<p> $message </p>";
    }
?>
<fieldset>
    <legend>My stats</legend>
    <p>
        Name: <?php echo htmlspecialchars($character->name()); ?><br>
        Race: <?php echo htmlspecialchars($character->race()); ?><br>
        Item: <?php echo htmlspecialchars($character->item()->name()); ?><br>
        Strength: <?php echo $character->strength(); ?><br>
        Health: <?php echo $character->health(); ?><br>
        Level: <?php echo $character->level(); ?><br>
        Experience: <?php echo $character->experience(); ?>
    </p>
</fieldset>
<fieldset>
    <legend>Who would you like to hit?</legend>
    <p>
    <?php
        $characters = $manager->getEnemies($character->name());
        if (empty($characters)) {
            echo "There's no one to hit!";
        }
        else {
            foreach ($characters as $enemy) 
                echo "<a href='index.php?hit={$enemy->id()}'>", htmlspecialchars($enemy->name()), "</a> (Race: {$enemy->race()}, Strength: {$enemy->strength()}, Health: {$enemy->health()}, Level: {$enemy->level()}, Experience: {$enemy->experience()})<br>";
        }
    ?>
    </p>
</fieldset>
<p><a href="index.php?logout=1">Log out</a></p>