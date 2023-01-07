<div class="container-fluid">


    <div class="d-flex align-content-center justify-content-center my-5">
        <h3>Liste des utilisateurs </h3>
    </div>

    <!--    LISTE DES ADMINISTRATEURS-->

    <div class="row offset-lg-1 my-5">
        <div class="col-md-3 col-lg-3 shadowBox my-sm-4 mx-md-4 mx-lg-4">
            <h3> Administrateurs </h3>
            <div class="my-4">
                <form method="post" class="d-flex">
                    <input required class="form-control me-2" type="search" name="searchValue"
                           placeholder="administrateurs"
                           aria-label="Search">
                    <input type='hidden' name='controller' value='utilisateur'>
                    <button class="btn btn-dark text-nowrap" name='action' value='readAllAdminBySearchValue'
                            type="submit">Rechercher
                    </button>
                </form>
            </div>

            <?php
            $countA = 0;
            foreach ($administrateurs as $administrateur) {
                echo '<ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($administrateur->getLogin()) .
                    '&controller=utilisateur">' . htmlspecialchars($administrateur->getLogin()) . '</a></li></ul>';
                $countA++;
            }
            if ($countA == 0) echo 'Il n\'y a pas d\'administrateur avec un login contenant "' . $_REQUEST['searchValue'] . '".';
            ?>
        </div>

        <!--        LISTE DES ORGANISATEURS-->

        <div class="col-md-3 col-lg-3 shadowBox my-sm-4 mx-md-4 mx-lg-4">
            <h3> Organisateurs </h3>
            <div class="my-4">
                <form method="post" class="d-flex">
                    <input required class="form-control me-2" type="search" name="searchValue"
                           placeholder="organisateurs"
                           aria-label="Search">
                    <input type='hidden' name='controller' value='utilisateur'>
                    <button class="btn btn-dark text-nowrap" name='action' value='readAllOrganisateurBySearchValue'
                            type="submit">Rechercher
                    </button>
                </form>
            </div>

            <?php
            $countO = 0;
            foreach ($organisateurs as $organisateur) {

                echo '
    <ul><li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($organisateur->getLogin()) .
                    '&controller=utilisateur">' . htmlspecialchars($organisateur->getLogin()) . '</a></li>
    </ul>';
                $countO++;

            }
            if ($countO == 0) echo 'Il n\'y a pas d\'organisateur avec un login contenant "' . $_REQUEST['searchValue'] . '".';
            ?>
        </div>


        <!--        LISTE DES UTILISATEURS-->

        <div class="col-md-3 col-lg-3 shadowBox my-sm-4 mx-md-4 mx-lg-4">
            <h3> Utilisateurs </h3>
            <div class="my-3">
                <form method="post" class="d-flex">
                    <input required class="form-control me-2" type="search" name="searchValue"
                           placeholder="utilisateurs"
                           aria-label="Search">
                    <input type='hidden' name='controller' value='utilisateur'>
                    <button class="btn btn-dark text-nowrap" name='action' value='readAllUtilisateurBySearchValue'
                            type="submit">Rechercher
                    </button>
                </form>
            </div>


            <?php
            $countU = 0;
            foreach ($utilisateurs as $user) {

                echo '
    <ul>
        <li style="list-style: none"><a href="frontController.php?action=read&login=' . rawurlencode($user->getLogin()) .
                    '&controller=utilisateur">' . htmlspecialchars($user->getLogin()) . '</a></li>
    </ul>
    ';
                $countU++;
            }
            if ($countU == 0) echo 'Il n\'y a pas d\'utilisateur avec un login contenant "' . $_REQUEST['searchValue'] . '".';
            ?>
        </div>
    </div>


    <div class="d-flex align-content-center justify-content-center my-5">
        <a class="btn btn-primary text-nowrap align-self-center"
           href="frontController.php?controller=utilisateur&action=create">Créer un utilisateur</a>
    </div>