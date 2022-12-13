<h2>Propositions</h2>
<form action="frontController.php">
    <?php use Themis\Lib\ConnexionUtilisateur;

    foreach ($propositions as $proposition) :
        $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
        $propositionInURL = rawurlencode($proposition->getIdProposition());
        $questionInURL = rawurlencode($proposition->getIdQuestion());
        $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL"; ?>

        <div class="col-6 boxProposition overflow-hidden rounded-5 my-3">
            <div class="nestedDivQuestion overflow-hidden text-start">
                <div class=" mx-3 d-flex flex-row justify-content-between align-items-center">
                    <a id="containerQuestion" href="<?= $hrefRead ?>">
                        <h3><?= $titrePropositionHTML ?></h3>
                    </a>
                    <select required class="form-select" aria-label="Select Vote" name="valueVote<?= $propositionInURL ?>" style="width: 160px;">
                        <option selected></option>
                        <option value="-2">Très Hostile</option>
                        <option value="-1">Hostile</option>
                        <option value="0">Indifférent</option>
                        <option value="1">Favorable</option>
                        <option value="2">Très Favorable</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-check">
        </div>
    <?php endforeach; ?>
    <p>
        <input type="hidden" name="controller" value="vote">
        <input type="hidden" name="action" value="submitVote">
        <?php if (ConnexionUtilisateur::isConnected()) : ?>
            <input type="hidden" name="loginVotant" value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
        <?php endif ?>
        <input type="hidden" name="idQuestion" value="<?= $questionInURL ?>">
        <input type="submit" value="Voter"/>
    </p>
</form>
