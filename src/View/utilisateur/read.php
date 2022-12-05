<?php

use Themis\Lib\ConnexionUtilisateur;

$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="container-fluid">
    <div class="row my-5 gy-4">
        <div class="offset-md-4 offset-lg-4 col-md-6 col-lg-4">
            <div class="shadowBox card card-body border-0 rounded-4" style="background: #C7B198;">
                <div class="d-flex align-content-center justify-content-center">
                    <h3>Mon compte</h3>
                </div>
                Login :
                <?= htmlspecialchars($utilisateur->getLogin()) ?> <br>

                Nom Utilisateur : <?= htmlspecialchars($utilisateur->getNom()) ?> <br>
                Adresse email : <?= htmlspecialchars($utilisateur->getAdresseMail()) ?><br>
                Date de Naissance : <?= htmlspecialchars($utilisateur->getDateNaissance()) ?><br>
                <?php if ($utilisateur->isEstAdmin()) : ?>
                    Droits : Administrateur
                <?php else: ?>
                    Droits : Utilisateurs
                <?php endif ?>
                <div class="d-flex align-content-center justify-content-center my-3">
                    <?php if (ConnexionUtilisateur::isUser($utilisateurInURL) || ConnexionUtilisateur::isAdministrator()) : ?>
                    <a class="btn btn-dark text-nowrap mx-1" href='<?= $hrefDelete ?>'> Supprimer</a>
                    <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
                    <?php endif ?>
                </div>

            </div>
        </div>

    </div>
</div>

