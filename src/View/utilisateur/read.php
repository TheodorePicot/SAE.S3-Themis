<?php
$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="container-fluid">
    <div class="row my-5 gy-4">
        <div class="offset-4 col-4">
            <div class="shadowBox card card-body border-0 rounded-4" style="background: #C7B198;">
                <div class="d-flex align-content-center justify-content-center">
                    <h3>Mon compte</h3>
                </div>
                Login :
                <?= htmlspecialchars($utilisateur->getLogin()) ?> <br>

                Nom Utilisateur : <?= htmlspecialchars($utilisateur->getNom()) ?> <br>
                Adresse email : <?= htmlspecialchars($utilisateur->getAdresseMail()) ?><br>
                Date de Naissance : <?= htmlspecialchars($utilisateur->getDateNaissance()) ?><br>
                <div class="d-flex align-content-center justify-content-center my-3">
                    <a class="btn btn-dark text-nowrap mx-1" href='<?= $hrefDelete ?>'> Supprimer</a>
                    <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
                </div>

            </div>
        </div>

    </div>
</div>

