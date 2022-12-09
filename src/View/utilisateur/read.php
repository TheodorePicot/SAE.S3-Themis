<?php

use Themis\Lib\ConnexionUtilisateur;

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="container-fluid">
    <div class="offset-4 row my-5">
        <div class="col col-lg-12">
            <h1>
                <img id="accountImgPage" alt="compte" src="assets/img/account.png">
                <?= htmlspecialchars($utilisateur->getLogin()) ?> </h1>
        </div>
        <div class="col-lg-3 my-lg-5 ">
            <h3>Prenom <br></h3>
            <div class="" style="background:;"
            ">
            <?= htmlspecialchars($utilisateur->getPrenom()) ?><br>
        </div>
        <h3>Adresse email <br></h3>
        <?= htmlspecialchars($utilisateur->getAdresseMail()) ?><br>
        <?php if ($utilisateur->isAdmin()) : ?>
            <h3> Droits <br></h3>
            Administrateur
        <?php elseif ($utilisateur->isOrganisateur()): ?>
            Droits <br>
            Organisateur
        <?php else : ?>
            Droits <br>
            Utilisateur
        <?php endif ?>
    </div>
    <div class="col-lg-3 my-lg-5 ">
        <h3>Nom <br></h3>
        <?= htmlspecialchars($utilisateur->getNom()) ?><br>
        <h3>Date de Naissance <br></h3>
        <?= htmlspecialchars($utilisateur->getDateNaissance()) ?><br>
    </div>

    <div class="col-lg-12 my-5">
        <?php if (ConnexionUtilisateur::isUser($utilisateurInURL) || ConnexionUtilisateur::isAdministrator()) : ?>
            <a class="btn btn-dark text-nowrap mx-1" href='<?= $hrefDelete ?>'> Supprimer</a>
            <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
        <?php endif ?>
    </div>
</div>


</div>

