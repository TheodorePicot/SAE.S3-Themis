<form method="get" action="frontController.php">
    <fieldset>
        <div id='containerFormulaire' class='container text-center my-5' style="border: 2px solid">
            <h2><?= $message ?></h2>

            <p>
                <label for="titreQuestion">Titre</label> :
                <input type="text" placeholder="?" value="<?= htmlspecialchars($question->getTitreQuestion()) ?>"
                       name="titreQuestion" id="titreQuestion" max="99" maxlength="99" required/>
            </p>

            <p>
                <label for="descriptionQuestion">Description</label> :
                <textarea placeholder="Decrire la question" name="descriptionQuestion"
                          id="descriptionQuestion"
                          required rows="5" cols="40"
                          maxlength="700"><?= htmlspecialchars($question->getDescriptionQuestion()) ?></textarea>
            </p>

            <h3>Auteurs et Votants</h3>

            <?php require_once __DIR__ . "/../utilisateur/listForVotantsUpdate.php" ?>

            <?php require_once __DIR__ . "/../utilisateur/listForAuteursUpdate.php" ?>

            <h3>Calendrier</h3>

            <p>
                <label for="dateDebutProposition">Date de début des propositions</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= htmlspecialchars($question->getDateDebutProposition()) ?>"
                       name="dateDebutProposition" id="dateDebutProposition" required/>
            </p>

            <p>
                <label for="dateFinProposition">Date de fin des propositions</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= htmlspecialchars($question->getDateFinProposition()) ?>"
                       name="dateFinProposition" id="dateFinProposition" required/>
            </p>
            <p>
                <label for="dateDebutVote">Date de début du vote</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= htmlspecialchars($question->getDateDebutVote()) ?>"
                       name="dateDebutVote" id="dateDebutVote" required/>
            </p>
            <p>
                <label for="dateFinVote">Date de fin du vote</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= htmlspecialchars($question->getDateFinVote()) ?>"
                       name="dateFinVote"
                       id="dateFinVote" required/>
            </p>

            <input type="hidden" name="idQuestion" value="<?= htmlspecialchars($question->getIdQuestion()) ?>">
            <input type='hidden' name='action' value='updated'>

            <?php require_once __DIR__ . "/../section/listByQuestionForUpdate.php" ?>

            <p>
                <input type="submit" value="Envoyer"/>
            </p>
        </div>
    </fieldset>
</form>