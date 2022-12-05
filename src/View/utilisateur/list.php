<?php
echo '<p> Administrateurs : </p>';
foreach ($utilisateurs as $user) {
    if ($user->isEstAdmin()) {
        echo '<ul><li><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
            '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
    }
}
echo '<p> Utilisateurs : </p>';
foreach ($utilisateurs as $user) {
    if (!$user->isEstAdmin()) {
        echo '<ul><li><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
            '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
    }
}

