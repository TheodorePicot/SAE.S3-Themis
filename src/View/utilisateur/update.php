<?php
$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class='container'>
    <div class="row my-5">
        <form method="get" action="frontController.php">

            <div class="offset-lg-3 offset-md-3 col-md-6 col-lg-6">
                <h5><label class="my-2" for="login">Login </label></h5>
                <input class="form-control" type="text" name="login" id="login"
                       value="<?= htmlspecialchars($utilisateur->getLogin()) ?>">

                <h5><label class="my-2" for="nom">Nom Utilisateur  </label></h5>
                <input class="form-control" type="text" name="nom" id="nom"
                       value="<?= htmlspecialchars($utilisateur->getNom()) ?>">

                <h5><label class="my-2 for="prenom">Prénom Utilisateur  </label></h5>
                <input class="form-control" type="text" name="prenom" id="prenom"
                       value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>">

                <h5><label class="my-2 for="adresseMail">Adresse Mail </label></h5>
                <input class="form-control" type="text" name="adresseMail" id="adresseMail"
                       value="<?= htmlspecialchars($utilisateur->getAdresseMail()) ?>">

                <h5><label class="my-2 for="dateNaissance">Date de Naissance </label></h5>
                <input class="form-control" type="date" name="dateNaissance" id="dateNaissance"
                       value="<?= htmlspecialchars($utilisateur->getDateNaissance()) ?>">

                <h5><label class="my-2 for="mdp">Mot de Passe </label></h5>
                <input class="form-control" type="text" name="mdp" id="mdp"
                       value="<?= htmlspecialchars($utilisateur->getMdp()) ?>">


                <input type='hidden' name='action' value='updated'>
                <input type='hidden' name='controller' value='utilisateur'>

                <div class="d-flex align-content-center justify-content-center">

                    <input class="btn btn-dark" type="submit" value="Envoyer"/>
                </div>
            </div>

        </form>
    </div>

</div>

