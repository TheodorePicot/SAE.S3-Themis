
<div id="listeQuestion" class="container-fluid">
    <div class="row mx-5 my-4 gy-4 gx-5">


        <select name="formal" onchange="javascript:handleSelect(this)">
            <option style="font-weight: bold">Filtre</option>
            <option value="readAll" <?php if(isset($_GET['action']) && $_GET['action'] == 'readAll') echo "selected"?>>Toutes les questions</option>
            <option value="readAllWrite" <?php if(isset($_GET['action']) && $_GET['action'] == 'readAllWrite') echo "selected"?> >Questions en cours d'écriture</option>
            <option value="readAllVote" <?php if(isset($_GET['action']) && $_GET['action'] == 'readAllVote') echo "selected"?> >Questions en cours de vote</option>
            <option value="readAllFinish" <?php if(isset($_GET['action']) && $_GET['action'] == 'readAllFinish') echo "selected"?> >Questions terminées</option>
        </select>
<!-- TODO refactor les ifs-->
        <script type="text/javascript">
            function handleSelect(elm)
            {
                window.location = "frontController.php?action=" + elm.value;
            }
        </script>

<?php foreach ($questions as $question) :
$titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
?>

            <div id="question" class="box overflow-hidden rounded-2 col-md-6 col-lg-4"  >
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
