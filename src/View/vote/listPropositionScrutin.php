<h2>Propositions</h2>
<form method="post" action="frontController.php">
    <?php use Themis\Lib\ConnexionUtilisateur;
    use Themis\Model\Repository\ScrutinUninominalRepository;

    foreach ($propositions as $proposition) :
        $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
        $propositionInURL = rawurlencode($proposition->getIdProposition());
        $questionInURL = rawurlencode($proposition->getIdQuestion());
        $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL";
        ?>

        <div class="col-6 boxProposition overflow-hidden rounded-5 my-3">
            <div class="nestedDivQuestion overflow-hidden text-start">
                <div class=" mx-3 d-flex flex-row justify-content-between align-items-center">
                    <a id="containerQuestion" href="<?= $hrefRead ?>">
                        <h3><?= $titrePropositionHTML ?></h3>
                    </a>
                    <input class="form-check-input" <?= (ConnexionUtilisateur::isConnected() && (new ScrutinUninominalRepository())->votantHasAlreadyVotedForPropositionScrutin(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition())) ? "checked" : ""; ?> type="radio" name="idPropositionVote" value="<?= $proposition->getIdProposition() ?>" id="idPropositionVote">
                    <label class="form-check-label" for="idPropositionVote">
                    </label>
                </div>
            </div>
        </div>
        <div class="form-check">
        </div>
    <?php endforeach; ?>
        <input type="hidden" name="controller" value="vote">
        <input type="hidden" name="action" value="submitVote">
        <?php if (ConnexionUtilisateur::isConnected()) : ?>
            <input type="hidden" name="loginVotant" value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
        <?php endif ?>
        <input type="hidden" name="idQuestion" value="<?= $questionInURL ?>">
        <input type="submit" value="Voter"/>

</form>
