<div id="listeQuestion" class="container-fluid">

    <div class="row mx-md-3 mx-lg-5 my-5 gy-4">
        <div class="dropdown col-md-4 col-lg-7">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                Filtre
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="frontController.php?action=readAll">Toutes les questions</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllCurrentlyInWriting">Questions
                        en cours
                        d'écriture</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllCurrentlyInVoting">Questions en
                        cours de
                        vote</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllFinished">Questions
                        terminées</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllByAlphabeticalOrder">Par Ordre
                        Alphabétique</a></li>

            </ul>
        </div>

            <form method="post" class="d-flex col-sm-12 col-md-8 col-lg-5">
                <input class="form-control me-2" type="search" name="searchValue" placeholder="Rechercher une question"
                       aria-label="Search">
                <button class="btn btn-primary text-nowrap" name='action' value='readAllBySearchValue'
                        type="submit">Rechercher
                </button>
            </form>

    </div>

    <div class="row mx-md-3 mx-lg-5 my-5 gy-4   ">

        <?php foreach ($questions as $question) :
            $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
            $descriptionQuestion = htmlspecialchars($question->getShortDescriptionQuestion());
            $loginOrganisateur = htmlspecialchars($question->getLoginOrganisateur());
            $questionInURL = rawurlencode($question->getIdQuestion());
            $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
            ?>
        <div class="overflow-hidden col-sm-12 col-md-6 col-lg-4" style="height: 250px">
            <a class="card rounded-3 overflow-hidden shadowBox text-center" href="<?= $hrefRead ?>" style="height: 96%">
                <div class="card-header">
                    <img class="accountImg" alt="compte" src="assets/img/account.png">

                    <?= $loginOrganisateur ?>

                </div>
                <div class="card-body ">
                    <h5 class="card-title"><?= $titreQuestionHTML ?></h5>

                    <p class="card-text"><?= $descriptionQuestion?>
                </div>
            </a>
        </div>


        <?php endforeach; ?>

    </div>
</div>

