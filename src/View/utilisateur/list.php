<div class="container-fluid mx-3">

    <div class="row">
        <div class="col-md-4 col-lg-4">
            <h3> Administrateurs </h3>
            <?php
            foreach ($utilisateurs as $user) {
                if ($user->isAdmin()) {
                    echo '<ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
                }
            }
            ?>
        </div>

        <div class="col-md-4 col-lg-4">
            <h3> Organisateurs </h3>
            <?php
            foreach ($utilisateurs as $user) {
                if ($user->isOrganisateur() && !$user->isAdmin()) {
                    echo '
    <ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li>
    </ul>';
                }
            }
            ?>
        </div>

        <div class="col-md-4 col-lg-4">
            <h3> Utilisateurs </h3>
            <?php
            foreach ($utilisateurs as $user) {
                if (!$user->isAdmin() && !$user->isOrganisateur()) {
                    echo '
    <ul>
        <li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li>
    </ul>
    ';
                }
            }
            ?>
        </div>

    </div>