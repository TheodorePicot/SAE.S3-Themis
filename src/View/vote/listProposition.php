<h2>Propositions</h2>
<form action="frontController.php">
    <input type="hidden" name="controller" value="vote">
    <input type="hidden" name="action" value="saveVote">
        <input type="hidden" name="login" value="jacques64">
    <?php foreach ($propositions as $proposition) :
        $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
        $propositionInURL = rawurlencode($proposition->getIdProposition());
        $questionInURL = rawurlencode($proposition->getIdQuestion());
        $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL"; ?>

        <div class="boxProposition overflow-hidden rounded-5 my-3">
            <div class="nestedDivQuestion overflow-hidden text-start">
                <a id="containerQuestion" href="<?= $hrefRead ?>">
                    <div class="mx-3">
                        <h3><?= $titrePropositionHTML ?></h3>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    <p>
        <input type="submit" value="Voter"/>
    </p>
</form>
