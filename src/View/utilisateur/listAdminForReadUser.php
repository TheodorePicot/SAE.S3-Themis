<?php
foreach ($utilisateurs
               as $user):
    $userLogin = rawurlencode($user->getLogin());
    $hrefReadUser ="frontController.php?controller=utilisateur&action=read&login=" . $userLogin;
    if ($user->isAdmin()) {
        ?>
        <a href=<?=$hrefReadUser?>>
            <p><?= htmlspecialchars($user->getLogin()) ?></p>
        </a>
        <?php
    }
endforeach; ?>