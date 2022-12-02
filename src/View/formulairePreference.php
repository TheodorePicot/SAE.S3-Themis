<?php

use Themis\Lib\PreferenceControleur; ?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form method="get" action="frontController.php">
    <fieldset>
        <input type="radio" id="questionId" name="controleur_defaut"
               value="question" <?= (PreferenceControleur::lire() == "question") ? "checked" : "" ?>>
        <label for="questionId">Question</label>
        <input type="radio" id="utilisateurId" name="controleur_defaut"
               value="utilisateur" <?= (PreferenceControleur::lire() == "utilisateur") ? "checked" : "" ?>>
        <label for="utilisateurId">Utilisateur</label>
        <input type='hidden' name='action' value='enregistrerPreference'>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>

    </fieldset>
</form>


</body>
</html>
