<h2>Propositions</h2>
<form action="frontController.php">
    <input type="hidden" name="controller" value="vote">
    <input type="hidden" name="action" value="saveVote">
    <!--    <input type="hidden" name="controller" value="vote">-->

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
        <label>
            <input type="radio" name="idProposition" value="<?= $proposition->getIdProposition() ?>">
        </label>
    <?php endforeach; ?>
    <p>
        <input type="submit" value="Voter"/>
    </p>
</form>
