<?php

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class='container'>
    <div class="row my-5">
        <form method="post" action="frontController.php">

            <div class="offset-lg-3 offset-md-3 col-md-6 col-lg-6">
                <h5><label class="my-2" for="mdpAncien">Ancien Mot de Passe&#42; </label></h5>
                <input class="form-control <?= isset($_GET["invalidOld"]) ? "is-invalid" : "" ?>" type="password" name="mdpAncien" id="mdpAncien"
                       value="">

                <h5><label class="my-2" for="mdp">Nouveau Mot de Passe&#42; </label></h5>
                <input class="form-control <?= isset($_GET["invalidNew"]) ? "is-invalid" : "" ?>" type="password" name="mdp" id="mdp"
                       value="">

                <h5><label class="my-2" for="mdpConfirmation">Confirmation Nouveau Mot de Passe&#42; </label></h5>
                <input class="form-control <?= isset($_GET["invalidNew"]) ? "is-invalid" : "" ?>" type="password" name="mdpConfirmation" id="mdpConfirmation"
                       value="">

                <input type='hidden' name='action' value='updatedForPassword'>
                <input type='hidden' name='controller' value='utilisateur'>
                <input type="hidden" name="login" value="<?= $utilisateur->getLogin() ?>">
                <div class="d-flex align-content-center justify-content-center">

                    <input class="btn btn-dark" type="submit" value="Envoyer"/>
                </div>
            </div>

        </form>
    </div>

</div>

