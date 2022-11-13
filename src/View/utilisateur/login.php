<form method="get" action="frontController.php">
    <fieldset>
<!--        <div id='containerFormLogin' class='container text-center my-5' style="border: 2px solid">-->
        <legend>Se connecter</legend>
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
            <a href="frontController.php?controller=utilisateur&action=create"> S'incrire</a>
        </p>

    </fieldset>
</form>
