<div id="listeQuestion" class="container-fluid my-5 mx-5 d-flex flex-row flex-wrap">
    <h2>Propositions</h2>
    <?php foreach ($propositions as $proposition) :
        $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
        $propositionInURL = rawurlencode($proposition->getIdProposition());
        $questionInURL = rawurlencode($proposition->getIdQuestion());

        $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL";
        ?>

        <div class="boxProposition overflow-hidden rounded-2 col-11 m-1">
            <div class="nestedDivQuestion overflow-hidden text-start">
                <a id="containerQuestion" href="<?= $hrefRead ?>">
                    <h3><?= $titrePropositionHTML ?></h3>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>