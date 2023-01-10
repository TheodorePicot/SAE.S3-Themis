<?php
foreach ($utilisateurs
               as $user):
    $userLogin = rawurlencode($user->getLogin());
    $hrefReadUser ="frontController.php?controller=utilisateur&action=read&login=" . $userLogin;
    if ($user->isAdmin()) {
        ?>
        <a href=<?=$hrefReadUser?>>
        <?= htmlspecialchars($user->getLogin()) ?>
        </a>
        <?php
    }
endforeach; ?>