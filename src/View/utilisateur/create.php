<form method="get" action="frontController.php">
    <fieldset>
        <legend>S'inscire</legend>

        <input type="hidden" name="controller" value="utilisateur">
        <input type="hidden" name="action" value="created">

        <p>
            <label for="login">Login</label> :
            <input type="text" placeholder="Paul16" name="login" id="login" required/>
        </p>

        <p>
            <label for="adresseMail">Email</label> :
            <input type="text" placeholder="dupontpaul1610@gmail.com" name="adresseMail" id="adresseMail" required/>
        </p>

        <p>
            <label for="nom">Nom</label> :
            <input type="text" placeholder="Dupont" name="nom" id="nom" required/>
        </p>

        <p>
            <label for="prenom">Prénom</label> :
            <input type="text" placeholder="Paul" name="prenom" id="prenom" required/>
        </p>

        <p>
            <label for="dateNaissance">Date de naissance</label> :
            <input type="date" name="dateNaissance" id="dateNaissance" required/>
        </p>

        <p>
            <label for="mdp">Mot de passe</label> :
            <input type="password" name="mdp" id="mdp" minlength="8" required/>
        </p>

        <p>
            <label for="mdp2">Confirmation mot de passe</label> :
            <input type="password" name="mdp2" id="mdp2" minlength="8" required/>
        </p>

        <p>
            <input type="submit" value="Confirmer"/>
        </p>

    </fieldset>
</form>
