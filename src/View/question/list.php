<div id="listeQuestion" class="container-fluid">

    <div class="row mx-5 my-5 gy-4 gx-5 d-flex">
        <div class="dropdown col-7">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
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

            <form class="d-flex col-md-5 col-lg-5">
                <input class="form-control me-2" type="search" name="searchValue" placeholder="Search"
                       aria-label="Search">
                <button class="btn btn-dark text-nowrap" name='action' value='readAllBySearchValue'
                        type="submit">Rechercher
                </button>
            </form>
    </div>





    <div class="row mx-5 my-5 gy-4 gx-5">

        <?php foreach ($questions as $question) :
            $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
            $questionInURL = rawurlencode($question->getIdQuestion());
            $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
            ?>

            <div class="box overflow-hidden rounded-2 col-md-6 col-lg-4">
                <div class="nestedDivQuestion overflow-hidden text-center">
                    <a class="lienQuestion btn m-3" href="<?= $hrefRead ?>">
                        <h3><?= $titreQuestionHTML ?></h3>
                        <p><?= $parser->text($question->getShortDescriptionQuestion()) ?></p>
                    </a>
                </div>
            </div>


        <?php endforeach; ?>

    </div>
</div>

