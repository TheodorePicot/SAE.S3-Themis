<form method="get" action="frontController.php">
    <fieldset>
        <legend>Se connecté</legend>

        <p>
            <label for="email">Email</label> :
            <input type="text" placeholder="dupontpaul1610@gmail.com" name="email" id="email" required/>
        </p>

        <p>
            <label for="mdp">Mot de passe</label> :
            <input type="password" name="mdp" id="mdp" minlength="8" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
            <a href="signUp.php"> S'incrire</a>
        </p>

    </fieldset>
</form>
