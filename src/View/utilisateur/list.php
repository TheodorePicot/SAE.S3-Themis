<div class="container-fluid">


    <div class="row">
        <form class=" offset-lg-6 offset-md-4 d-flex col-sm-12 col-md-8 col-lg-5">
            <input class="form-control me-2" type="search" name="searchValue" placeholder="Rechercher un utilisateur"
                   aria-label="Search">
            <input type='hidden' name='controller' value='utilisateur'>
            <button class="btn btn-dark text-nowrap" name='action' value='readAllBySearchValue'
                    type="submit">Rechercher
            </button>
        </form>
    </div>


    <div class="row offset-lg-1 my-5">
        <div class="col-md-3 col-lg-3 shadowBox   my-sm-4 mx-md-4 mx-lg-4">
            <h3> Administrateurs </h3>
            <?php
            $countA = 0;
            foreach ($utilisateurs as $user) {
                if ($user->isAdmin()) {
                    echo '<ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li></ul>';
                    $countA++;
                }
            }
            if ($countA == 0) echo 'Il n\'y a pas d\'administrateur avec un login contenant "' . $_GET['searchValue'] . '".';
            ?>
        </div>

        <div class="col-md-3 col-lg-3 shadowBoxProposition  my-sm-4 mx-md-4 mx-lg-4">
            <h3> Organisateurs </h3>
            <?php
            $countO = 0;
            foreach ($utilisateurs as $user) {
                if ($user->isOrganisateur() && !$user->isAdmin()) {
                    echo '
    <ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li>
    </ul>';
                    $countO++;
                }
            }
            if ($countO == 0) echo 'Il n\'y a pas d\'organisateur avec un login contenant "' . $_GET['searchValue'] . '".';
            ?>
        </div>

        <div class="col-md-3 col-lg-3 shadowBox my-sm-4 mx-md-4 mx-lg-4">
            <h3> Utilisateurs </h3>
            <?php
            $countU = 0;
            foreach ($utilisateurs as $user) {
                if (!$user->isAdmin() && !$user->isOrganisateur()) {
                    echo '
    <ul>
        <li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                        '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li>
    </ul>
    ';
                    $countU++;
                }
            }
            if ($countU == 0) echo 'Il n\'y a pas d\'utilisateur avec un login contenant "' . $_GET['searchValue'] . '".';
            ?>
        </div>

    </div>