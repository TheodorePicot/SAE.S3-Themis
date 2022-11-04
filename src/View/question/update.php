<form method="get" action="frontController.php">
    <fieldset>

        <div id='containerFormulaire' class='container text-center my-5' style="border: 2px solid">
            <h2>Mise à jour question</h2>

            <p>
                <label for="titreQuestion">Titre</label> :
                <input type="text" placeholder="Triss ou Yennefer ?" value="<?= $question->getTitreQuestion() ?>"
                       name="titreQuestion" id="titreQuestion" required/>
            </p>

            <p>
                <label for="descriptionQuestion">Description</label> :
                <textarea placeholder="What is the hell in the frick" name="descriptionQuestion" id="descriptionQuestion"
                          required rows="5" cols="40"><?= $question->getDescriptionQuestion() ?></textarea>
            </p>

            <p>
                <label for="dateDebutProposition">Date de début des propositions</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= $question->getDateDebutProposition() ?>"
                       name="dateDebutProposition" id="dateDebutProposition" required/>
            </p>

            <p>
                <label for="dateFinProposition">Date de fin des propositions</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= $question->getDateFinProposition() ?>"
                       name="dateFinProposition" id="dateFinProposition" required/>
            </p>
            <p>
                <label for="dateDebutVote">Date de début du vote</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= $question->getDateDebutVote() ?>"
                       name="dateDebutVote" id="dateDebutVote" required/>
            </p>
            <p>
                <label for="dateFinVote">Date de fin du vote</label> :
                <input type="date" placeholder="JJ/MM/YYYY" value="<?= $question->getDateFinVote() ?>" name="dateFinVote"
                       id="dateFinVote" required/>
            </p>

            <input type="hidden" name="idQuestion" value="<?= $question->getIdQuestion() ?>">
            <input type='hidden' name='action' value='updated'>

            <?php require_once __DIR__ . "/../section/listByQuestionForUpdate.php" ?>

            <p>
                <input type="submit" value="Envoyer"/>
            </p>
        </div>
    </fieldset>
</form>