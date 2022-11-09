<form method="get" action="frontController.php">
    <fieldset>
        <legend>Se connecté</legend>

        <p>
            <label for="login">Login</label> :
            <input type="text" placeholder="dupontpaul1610" name="login" id="login" required/>
        </p>

        <p>
            <label for="password">Mot de passe</label> :
            <input type="password" name="password" id="password" minlength="8" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
            <a href="create.php"> S'incrire</a>
        </p>

    </fieldset>
</form>
