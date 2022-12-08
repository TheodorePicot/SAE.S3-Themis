<?php
echo '<p> Administrateurs : </p>';
foreach ($utilisateurs as $user) {
    if ($user->isAdmin()) {
        echo '<ul><li><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
            '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
    }
}
echo '<p> Organisateurs : </p>';
foreach ($utilisateurs as $user) {
    if ($user->isOrganisateur() && !$user->isAdmin()) {
        echo '<ul><li><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
            '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
    }
}
echo '<p> Utilisateurs : </p>';
foreach ($utilisateurs as $user) {
    if (!($user->isAdmin() && $user->isOrganisateur())) {
        echo '<ul><li><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
            '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
    }
}