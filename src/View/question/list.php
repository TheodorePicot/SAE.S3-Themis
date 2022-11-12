<!--<div id="containerListeQuestion">-->

    <div id="listeQuestion" class="container-fluid my-5 mx-5 d-flex flex-row flex-wrap">

        <?php foreach ($questions as $question) :
            $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
            $questionInURL = rawurlencode($question->getIdQuestion());
            $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
            ?>

            <a id="containerQuestion" href="<?= $hrefRead ?>">
                <div id="question" class="box my-2" style="border-radius: 10px">
                    <h3><?= $titreQuestionHTML ?></h3>
                    <p><?= $question->getShortDescriptionQuestion() ?></p>
                </div>
            </a>

        <?php endforeach; ?>
    </div>
<!--</div>-->
