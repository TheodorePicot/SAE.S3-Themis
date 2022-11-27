<?php
$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="container-fluid">
    <div class="row my-5 gy-4">
        <div class="col">
            Login : <?= htmlspecialchars($utilisateur->getLogin()) ?> <br>
            Nom Utilisateur : <?= htmlspecialchars($utilisateur->getNom()) ?> <br>
            Adresse email : <?= htmlspecialchars($utilisateur->getAdresseMail()) ?><br>
            Date de Naissance : <?= htmlspecialchars($utilisateur->getDateNaissance()) ?><br>
            <a class="btn btn-dark text-nowrap" href='<?= $hrefDelete ?>'> Supprimer</a>
            <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
        </div>
    </div>
</div>

