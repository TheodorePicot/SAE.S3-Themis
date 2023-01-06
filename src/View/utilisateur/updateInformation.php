<?php

use Themis\Lib\ConnexionUtilisateur;

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefUpdateInformation = "frontController.php?action=updateInformation&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdatePassword = "frontController.php?action=updatePassword&controller=utilisateur&login=" . $utilisateurInURL
?>


<div class='container-fluid'>

    <div class="row my-5">

        <div class="d-flex align-content-center justify-content-center">
            <h3>Modifier mes informations</h3>
        </div>
        <form method="post" action="frontController.php">

            <div class="offset-lg-3 offset-md-3 col-md-7 col-lg-7 my-5">

                <div class="row my-4">
                    <div class="col-md-3 col-lg-3">
                        <h5><label class="my-2" for="login">Login </label></h5>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <input class="form-control" type="text" name="login" id="login"
                               value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" readonly>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-3 col-lg-3">
                        <h5><label class="my-2" for="nom">Nom </label></h5>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <input class="form-control" type="text" name="nom" id="nom"
                               value="<?= htmlspecialchars($utilisateur->getNom()) ?>">
                    </div>

                </div>

                <div class="row my-4">
                    <div class="col-md-3 col-lg-3">
                        <h5><label class="my-2" for="prenom">Prénom </label></h5></div>
                    <div class="col-md-9 col-lg-9">
                        <input class="form-control" type="text" name="prenom" id="prenom"
                               value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>">
                    </div>
                </div>


                <div class="row my-4">
                    <div class="col-md-3 col-lg-3">
                        <h5><label class="my-2" for="adresseMail">Adresse Mail </label></h5>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <input class="form-control" type="text" name="adresseMail" id="adresseMail"
                               value="<?= htmlspecialchars($utilisateur->getAdresseMail()) ?>">
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-3 col-lg-3">
                        <h5><label class="my-2" for="dateNaissance">Date de Naissance </label></h5>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <input class="form-control" type="date" name="dateNaissance" id="dateNaissance"
                               value="<?= htmlspecialchars($utilisateur->getDateNaissance()) ?>">
                    </div>

                </div>

                <div class="my-4">
                    <?php if (ConnexionUtilisateur::isAdministrator() && ConnexionUtilisateur::isUser($_GET["login"])) : ?>
                        <h5><label class="InputAddOn-item" for="estAdmin_id">Administrateur</label></h5>
                        <input class="form-check" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id"
                            <?= ($utilisateur->isAdmin() == true) ? "checked" : "" ?> disabled>
                        <input type="hidden" placeholder="" name="estAdmin" value="on">

                        <h5><label class="InputAddOn-item" for="estOrganisateur">Organisateur</label></h5>
                        <p>
                            <input class="InputAddOn-field" type="checkbox" placeholder="" name="estOrganisateur"
                                   id="estOrganisateur" <?= ($utilisateur->isOrganisateur() == true) ? "checked" : "" ?>>
                            <input type="hidden" placeholder="" name="estAdmin" value="on">
                        </p>

                    <?php elseif (ConnexionUtilisateur::isAdministrator()) : ?>
                        <h5><label class="InputAddOn-item" for="estAdmin_id">Administrateur</label></h5>
                        <input class="form-check" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id"
                            <?= ($utilisateur->isAdmin() == true) ? "checked" : "" ?>>

                        <h5><label class="InputAddOn-item" for="estOrganisateur">Organisateur</label></h5>
                        <p>
                            <input class="InputAddOn-field" type="checkbox" placeholder="" name="estOrganisateur"
                                   id="estOrganisateur" <?= ($utilisateur->isOrganisateur() == true) ? "checked" : "" ?>>
                        </p>
                    <?php endif ?>
                </div>


                <input type='hidden' name='action' value='updatedForInformation'>
                <input type='hidden' name='controller' value='utilisateur'>

                <div class="my-3 d-flex align-content-center justify-content-center">
                    <?php if (ConnexionUtilisateur::isUser($utilisateur->getLogin())) : ?>
                        <a class="btn btn-dark text-nowrap my-2" href='<?= $hrefUpdatePassword ?>'> Modifier le mot de
                            passe</a>
                    <?php endif ?>
                </div>


                <div class="d-flex align-content-center justify-content-center">
                    <input class="btn btn-dark" type="submit" value="Enregistrer"/>
                </div>
            </div>

        </form>
    </div>
</div>

