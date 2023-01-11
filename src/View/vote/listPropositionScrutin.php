<div class="container-fluid">
    <div class="d-flex align-content-center justify-content-center my-5">
        <h2>Les propositions</h2>
    </div>
    <form method="post" action="frontController.php">
        <?php use Themis\Lib\ConnexionUtilisateur;
        use Themis\Model\Repository\ScrutinUninominalRepository;

        $count = 1;


        foreach ($propositions as $proposition) :
            $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
            $propositionInURL = rawurlencode($proposition->getIdProposition());
            $questionInURL = rawurlencode($proposition->getIdQuestion());
            $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL";
            ?>
            <div class="d-flex align-content-center justify-content-center my-2">
                <div class="col-6 boxProposition overflow-hidden rounded-5 my-3">
                    <div class=" mx-3 d-flex flex-row justify-content-between align-items-center">
                        <a href="<?= $hrefRead ?>">
                            <h3><?= $titrePropositionHTML ?></h3>
                        </a>
                        <div class="form-check">
                            <input class="form-check-input" <?= (ConnexionUtilisateur::isConnected() && (new ScrutinUninominalRepository())->votantHasAlreadyVotedForProposition(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition())) ? "checked" : ""; ?>
                                   type="radio" name="idPropositionVote"
                                   value="<?= $proposition->getIdProposition() ?>"
                                   id="idPropositionVote<?= $count ?>">

                            <label class="form-check-label" for="idPropositionVote<?= $count ?>">
                                Choix <?= $count ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-check">
            </div>
            <?php $count++; endforeach; ?>
        <input type="hidden" name="controller" value="vote">
        <input type="hidden" name="action" value="submitVote">
        <?php if (ConnexionUtilisateur::isConnected()) : ?>
            <input type="hidden" name="loginVotant" value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
        <?php endif ?>
        <input type="hidden" name="idQuestion" value="<?= $questionInURL ?>">
        <div class="d-flex align-content-center justify-content-center my-5">
            <input type="submit" class="btn btn-primary btn-lg" value="Voter"/>
        </div>
    </form>
</div>