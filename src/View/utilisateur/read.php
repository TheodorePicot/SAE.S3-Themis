<?php
$utilisateurInURL = rawurlencode($utilisateur->getLoginUtilisateur());
$hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
$hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;
$hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
$hrefReadAll = "frontController.php?action=readAll";
$lienRetourQuestion = "<a href=" . $hrefReadAll . ">Questions : </a>";
?>
