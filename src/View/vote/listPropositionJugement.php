<h2>Propositions</h2>
<form method="post" action="frontController.php">
    <?php use Themis\Lib\ConnexionUtilisateur;
    use Themis\Model\Repository\VotantRepository;
    use Themis\Model\Repository\VoteRepository;

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
                    <select required class="form-select" aria-label="Select Vote"
                            name="valueVote<?= $propositionInURL ?>" style="width: 160px;">
                        <?php
                        if ((new VotantRepository)->votantHasAlreadyVoted(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition())) :
                            $vote = (new VoteRepository)->selectVote(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition());
                        ?>
                            <option value=""></option>
                            <option <?php if ($vote->getValeur() == -2) echo "selected" ?> value="-2">A Rejeter</option>
                            <option <?php if ($vote->getValeur() == -1) echo "selected" ?> value="-1">Insuffisant</option>
                            <option <?php if ($vote->getValeur() == 0) echo "selected" ?> value="0">Passable</option>
                            <option <?php if ($vote->getValeur() == 2) echo "selected" ?> value="2">Assez Bien</option>
                            <option <?php if ($vote->getValeur() == 1) echo "selected" ?> value="1">Bien</option>
                            <option <?php if ($vote->getValeur() == 2) echo "selected" ?> value="2">Très Bien</option>

                        <?php else: ?>
                            <option value=""></option>
                            <option value="">A Rejeter</option>
                            <option value="">Insuffisant</option>
                            <option value="">Passable</option>
                            <option value="">Assez Bien</option>
                            <option value="">Bien</option>
                            <option value="">Très Bien</option>
                        <?php endif; ?>
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
