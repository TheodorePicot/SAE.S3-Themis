<?php

use Themis\Lib\ConnexionUtilisateur;

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdateInformation = "frontController.php?action=updateInformation&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdatePassword = "frontController.php?action=updatePassword&controller=utilisateur&login=" . $utilisateurInURL;
?>


<div class="container-fluid">
    <div class="offset-2 offset-lg-4 row my-5">
        <div class="col col-lg-12 my-5">
            <h3>
                <img id="accountImgPage" alt="compte" src="assets/img/account.png">
                <?= htmlspecialchars($utilisateur->getLogin()) ?>
                <small class="text-muted">
                    <?php if ($utilisateur->isAdmin()) : ?>
                        Administrateur
                    <?php elseif ($utilisateur->isOrganisateur()): ?>

                        Organisateur
                        <!--                --><?php //else : ?>
                        <!--                    Droits-->
                        <!--                    Utilisateur-->
                    <?php endif ?>
                </small>
            </h3>


        </div>
        <div class="col-lg-3 ">
            <h3>Prenom <br></h3>

            <?= htmlspecialchars($utilisateur->getPrenom()) ?><br>
            <div class="my-lg-3">
                <h3>Adresse email <br></h3>

                <?= htmlspecialchars($utilisateur->getAdresseMail()) ?><br>
            </div>
        </div>
        <div class="col-lg-3">
            <h3>Nom <br></h3>
            <?= htmlspecialchars($utilisateur->getNom()) ?><br>
            <div class="my-lg-3">
                <h3>Date de Naissance <br></h3>
                <?php
                $date = date_create($utilisateur->getDateNaissance());
                echo htmlspecialchars($date->format("d-m-Y")); ?><br>
            </div>
        </div>


        <div class="offset-1 col-lg-12 my-5">
            <?php if (ConnexionUtilisateur::isUser($utilisateurInURL) || ConnexionUtilisateur::isAdministrator()) : ?>
                <a class="btn btn-dark text-nowrap mx-1" href='<?= $hrefDelete ?>'> Supprimer</a>
                <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdateInformation ?>'> Mettre à jour information</a>

            <?php endif ?>
            <?php if (ConnexionUtilisateur::isUser($utilisateurInURL)) : ?>
                <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdatePassword ?>'> Modifier mot de passe</a>
            <?php endif ?>
        </div>


    </div>
</div>




