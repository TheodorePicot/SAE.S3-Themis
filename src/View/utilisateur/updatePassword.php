<?php

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class='container'>
    <div class="row my-5">
        <form method="post" action="frontController.php">

            <div class="offset-lg-3 offset-md-3 col-md-6 col-lg-6">
                <h5><label class="my-2" for="mdpAncien">Ancien mot de passe&#42; </label></h5>
                <input class="form-control <?= isset($_REQUEST["invalidOld"]) ? "is-invalid" : "" ?>" type="password" name="mdpAncien" id="mdpAncien"
                       value="">

                <h5><label class="my-2" for="mdp">Nouveau mot de passe&#42; </label></h5>
                <input class="form-control <?= isset($_REQUEST["invalidNew"]) ? "is-invalid" : "" ?>" type="password" name="mdp" id="mdp"
                       value="">

                <h5><label class="my-2" for="mdpConfirmation">Confirmer le nouveau mot de passe&#42; </label></h5>
                <input class="form-control <?= isset($_REQUEST["invalidNew"]) ? "is-invalid" : "" ?>" type="password" name="mdpConfirmation" id="mdpConfirmation"
                       value="">

                <input type='hidden' name='action' value='updatedForPassword'>
                <input type='hidden' name='controller' value='utilisateur'>
                <input type="hidden" name="login" value="<?= $utilisateur->getLogin() ?>">
                <div class="d-flex align-content-center justify-content-center">

                    <input class="my-4 btn btn-dark" type="submit" value="Envoyer"/>
                </div>
            </div>

        </form>
    </div>

</div>

