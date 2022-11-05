<form method="get" action="frontController?controller=utilisateur&action=signUp.php">
    <fieldset>
        <legend>S'inscire</legend>

        <p>
            <label for="email">Email</label> :
            <input type="text" placeholder="dupontpaul1610@gmail.com" name="email" id="email" required/>
        </p>

        <p>
            <label for="nom">Nom</label> :
            <input type="text" placeholder="Dupont" name="nom" id="nom" required/>
        </p>

        <p>
            <label for="prenom">Prenom</label> :
            <input type="text" placeholder="Paul" name="prenom" id="prenom" required/>
        </p>

        <p>
            <label for="pseudo">Pseudo</label> :
            <input type="text" placeholder="Paul16" name="pseudo" id="pseudo" required/>
        </p>

        <p>
            <label for="mdp">Mot de passe</label> :
            <input type="password" name="mdp" id="mdp" minlength="8" required/>
        </p>

        <p>
            <label for="mdp">Confirmation mot de passe</label> :
            <input type="password" name="mdp" id="mdp" minlength="8" required/>
        </p>

        <p>
            <input type="submit" value="Confirmer" />
        </p>

    </fieldset>
</form>
