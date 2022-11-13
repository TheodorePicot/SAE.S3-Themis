
<div id="listeQuestion" class="container-fluid">
    <div class="row mx-5 my-4 gy-4 gx-5">

<?php foreach ($questions as $question) :
$titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
?>

            <div id="question" class="box overflow-hidden rounded-2 col-xs-12 col-sm-6 col-md-4"  >
                <div class="nestedDivQuestion overflow-hidden">
                <a id="lienQuestion" class="btn" href="<?= $hrefRead ?>">
                <h3><?= $titreQuestionHTML ?></h3>
                <p><?= $question->getShortDescriptionQuestion() ?></p>
                </a>
                 </div>

            </div>
    <?php endforeach; ?>

    </div>
</div>
