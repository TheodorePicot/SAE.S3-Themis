<?php
$utilisateurInURL = rawurlencode($utilisateur->getLogin());
$hrefDelete = "frontController.php?action=delete&controller=utilisateur&login=" . $utilisateurInURL;
$hrefUpdate = "frontController.php?action=update&controller=utilisateur&login=" . $utilisateurInURL;;
?>


<div class="containerUtilisateur">

    <!--    QUESTION + DELETE UPDATE-->
    <div class='container my-5'>
        <p>
        <ul style='list-style: none'>
            <li>
                Login : <?= htmlspecialchars($utilisateur->getLogin()) ?>
            </li>
            <li>
                Nom Utilisateur : <?= htmlspecialchars($utilisateur->getNom()) ?>
            </li>
            <li>
                Prenom Utilisateur : <?= htmlspecialchars($utilisateur->getPrenom()) ?>
            </li>
            <li>
                Adresse email : <?= htmlspecialchars($utilisateur->getAdresseMail()) ?>
            </li>
            <li>
                Date de Naissance : <?= htmlspecialchars($utilisateur->getDateNaissance()) ?>
            </li>
            </p>


            <div id="containerUpdateDeleteUtilisateur">

                <a href='<?= $hrefDelete ?>'>
                    <div id="deleteButton" class="my-2" style='border:1px solid; border-radius: 4px;'>
                        <li>Supprimer</li>
                    </div>
                </a>
                <a href='<?= $hrefUpdate ?>'>
                    <div id="updateButton" class="my-2" style='border:1px solid; border-radius: 4px'>
                        <li>Mettre à jour</li>
                    </div>
                </a>
            </div>
        </ul>
    </div>
</div>

