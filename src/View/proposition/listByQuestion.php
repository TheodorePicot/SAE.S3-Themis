<div id="listeQuestion" class="container-fluid my-5 mx-5 d-flex flex-row flex-wrap">

    <?php foreach ($propositions as $proposition) :
        $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
        $propositionInURL = rawurlencode($proposition->getIdProposition());
        $questionInURL = rawurlencode($proposition->getIdQuestion());

        $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL";
        ?>

        <a id="containerQuestion" href="<?= $hrefRead ?>">
            <div id="question" class="box my-2" style="border-radius: 10px">
                <h3><?= $titrePropositionHTML ?></h3>
            </div>
        </a>

    <?php endforeach; ?>
</div>