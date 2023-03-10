<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\VotantRepository;


$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdateInformation = "frontController.php?action=updateInformation&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdatePassword = "frontController.php?action=updatePassword&controller=utilisateur&login=" . $utilisateurInURL;
?>

<div class="container-fluid">
    <div class="offset-1 offset-lg-3 row my-5">

        <div class="row my-5">
            <h3 class="col-lg-6 col-sm-12 align-self-center">
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
            <?php if ($utilisateur->isAdmin()) : ?>
                <div class="dropdown align-self-center col-sm-12 col-lg-3">
                    <a class="btn btn-primary text-nowrap align-self-center"
                       href="frontController.php?action=readAll&controller=utilisateur"> Outils d'administrations</a>

                </div>
            <?php endif ?>
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
            <div class="my-lg-3 text-nowrap">
                <h3>Date de Naissance <br></h3>
                <?php
                if ($utilisateur->getDateNaissance() != null) {
                    $date = date_create($utilisateur->getDateNaissance());
                    echo htmlspecialchars($date->format("d-m-Y"));
                } else
                    echo "non renseign??e" ?><br>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php if (!ConnexionUtilisateur::isUser($utilisateur->getLogin())) : ?>
        <div class="d-flex align-content-center justify-content-center my-3">
            <a class="btn btn-dark" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
               aria-expanded="false" aria-controls="multiCollapseExample1">Ses questions</a>
            <button class="btn btn-dark mx-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#multiCollapseExample2" aria-expanded="false"
                    aria-controls="multiCollapseExample2">Ses propositions
            </button>
        </div>
        <?php else : ?>
            <div class="d-flex align-content-center justify-content-center my-3">
                <a class="btn btn-dark" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                   aria-expanded="false" aria-controls="multiCollapseExample1">Mes questions</a>
                <button class="btn btn-dark mx-4" type="button" data-bs-toggle="collapse"
                        data-bs-target="#multiCollapseExample2" aria-expanded="false"
                        aria-controls="multiCollapseExample2">Mes propositions
                </button>
            </div>
        <?php endif ?>


        <div class="row my-4 mx-4">
            <div class="collapse multi-collapse my-3 my-lg-0 col-sm-12 col-lg-6 " id="multiCollapseExample1">
                <div class="card card-body">
                    <?php require_once __DIR__ . "/../question/listByUserForRead.php" ?>
                </div>
            </div>

            <div class="collapse multi-collapse my-3 my-lg-0 col-sm-12 col-lg-6" id="multiCollapseExample2">
                <div class="card card-body">
                    <?php require_once __DIR__ . "/../proposition/listByUserForRead.php" ?>
                </div>
            </div>
        </div>

        <div class="col-lg-12 d-flex align-content-center justify-content-center my-3">


                <?php if (ConnexionUtilisateur::isUser($utilisateur->getLogin())) : ?>
                    <a class="btn btn-primary text-nowrap mx-2 " href='<?= $hrefDelete ?>'
                       onclick="return confirm('??tes-vous s??r de vouloir continuer ?');"> Supprimer</a>

                    <a class="btn btn-primary text-nowrap" href='<?= $hrefUpdateInformation ?>'> Mettre ?? jour
                        mes informations</a>
                <?php elseif (ConnexionUtilisateur::isAdministrator()) : ?>
                    <a class="btn btn-primary text-nowrap mx-2 " href='<?= $hrefDelete ?>'
                       onclick="return confirm('??tes-vous s??r de vouloir continuer ?');"> Supprimer</a>

                    <a class="btn btn-primary text-nowrap" href='<?= $hrefUpdateInformation ?>'> Mettre ?? jour
                        ses informations</a>
                <?php endif ?>

        </div>

    </div>

</div>




