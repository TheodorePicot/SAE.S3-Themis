<?php
$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="containerUtilisateur">

    <!--QUESTION + DELETE UPDATE-->
    <div class='container my-5'>
        <form method="get" action="frontController.php">
            <p>
                <label for="login">Login : </label>
                <input type="text" name="login" id="login"
                       value="<?= htmlspecialchars($utilisateur->getLogin()) ?>">
            </p>
            <p>
                <label for="nom">Nom Utilisateur : </label>
                <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($utilisateur->getNom()) ?>">
            </p>
            <p>
                <label for="prenom">Prénom Utilisateur : </label>
                <input type="text" name="prenom" id="prenom"
                       value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>">
            </p>
            <p>
                <label for="adresseMail">Adresse Mail : </label>
                <input type="text" name="adresseMail" id="adresseMail"
                       value="<?= htmlspecialchars($utilisateur->getAdresseMail()) ?>">
            <p>
            <p>
                <label for="dateNaissance">Date de Naissance : </label>
                <input type="date" name="dateNaissance" id="dateNaissance"
                       value="<?= htmlspecialchars($utilisateur->getDateNaissance()) ?>">
            </p>
            <p>
                <label for="mdp">Mot de Passe : </label>
                <input type="text" name="mdp" id="mdp"
                       value="<?= htmlspecialchars($utilisateur->getMdp()) ?>">
            </p>

            <input type='hidden' name='action' value='updated'>
            <input type='hidden' name='controller' value='utilisateur'>

            <p>
                <input type="submit" value="Envoyer"/>
            </p>
        </form>
    </div>
</div>

