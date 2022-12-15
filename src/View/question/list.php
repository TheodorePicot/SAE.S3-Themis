<div id="listeQuestion" class="container-fluid">
    <div class="row mx-5 my-5 gy-4 gx-5">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                Filtre
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="frontController.php?action=readAll">Toutes les questions</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllCurrentlyInWriting">Questions en cours
                        d'écriture</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllCurrentlyInVoting">Questions en cours de
                        vote</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllFinished">Questions terminées</a></li>
                <li><a class="dropdown-item" href="frontController.php?action=readAllByAlphabeticalOrder">Par Ordre Trié</a></li>

            </ul>
        </div>

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
