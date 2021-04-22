<section class="container-fluid home">
    <article class="container home-content">
        <h1 class="modal-title">Wacken Open Air Metal Battle</h1>
        <h2>Choose or create your fighter!</h2>
        <br>
        <?php
            $characters = $manager->getList();
            if (!empty($characters)) {
                echo "
                    <form action='index.php' method='post'>
                        <label for='heroName'>Choose your hero:</label>
                        <p>(Number of characters in the database: {$manager->count()})</p>
                        <select class='form-control mb-1' id=heroName name='heroName' required>
                ";
                foreach ($characters as $hero){
                    echo "<option value='{$hero->name()}'>{$hero->name()} the {$hero->race()} (STR: {$hero->strength()}, HP: {$hero->health()}, LVL: {$hero->level()}, EXP: {$hero->experience()})</option>";
                }
                echo "
                        <input class='form-control btn btn-dark mb-1' id=fightHero type='submit' value='CHOOSE' name='use'>
                    </form>
                    <p>or</p>
                ";
            }
            if (isset($message)) { // IF there is a message to show
                echo "<p> $message </p>";
            }
        ?>
        <form action="index.php" method="post">
            <label for=heroName>Enter a new name:</label>
            <input class="form-control mb-1" id=heroName type="text" name="heroName" maxlength="50" required>
            <label for="heroRace">Choose your race:</label>
            <select class="form-control mb-1" id=heroRace name="heroRace" required>
                <option value="Human" selected>Human (-20% damage taken)</option>
                <option value="Orc">Orc (+40% max health)</option>
                <option value="Elf">Elf (30% chance deflect attack)</option>
                <option value="Vampire">Vampire (10% lifesteal each turn)</option>
            </select>
            <label for=heroItem>Choose your special item:</label>
            <select class="form-control mb-1" id=heroItem name="heroItem" required>
                <option value="Boots" selected>Boots (30% chance to dodge)</option>
                <option value="Staff">Staff (+20% healing)</option>
                <option value="Sword">Sword (+30% damage)</option>
                <option value="Bow">Bow (30% chance to attack twice)</option>
            </select>
            <input class="form-control btn btn-dark mb-1" type="submit" value="CREATE" name="create">    
        </form>
    </article>
</section>