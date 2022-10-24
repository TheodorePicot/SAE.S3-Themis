<form method="get" action="frontController.php">
    <fieldset>
        <legend>Mise à jour question</legend>

        <p>
            <label for="titreQuestion">Titre</label> :
            <input type="text" placeholder="Triss ou Yennefer ?" value="<?=$question->getTitreQuestion()?>" name="titreQuestion" id="titreQuestion" required/>
        </p>

        <p>
            <label for="dateDebutProposition">Date de début des propositions</label> :
            <input type="date" placeholder="JJ/MM/YYYY" value="<?=$question->getDateDebutProposition()?>" name="dateDebutProposition" id="dateDebutProposition" required/>
        </p>

        <p>
            <label for="dateFinProposition">Date de fin des propositions</label> :
            <input type="date" placeholder="JJ/MM/YYYY" value="<?=$question->getDateFinProposition()?>" name="dateFinProposition" id="dateFinProposition" required/>
        </p>
        <p>
            <label for="dateDebutVote">Date de début du vote</label> :
            <input type="date" placeholder="JJ/MM/YYYY" value="<?=$question->getDateDebutVote()?>" name="dateDebutVote" id="dateDebutVote" required/>
        </p>
        <p>
            <label for="dateFinVote">Date de fin du vote</label> :
            <input type="date" placeholder="JJ/MM/YYYY" value="<?=$question->getDateFinVote()?>" name="dateFinVote" id="dateFinVote" required/>
        </p>
        <input type="hidden" name="idQuestion" value="<?=$_GET["idQuestion"]?>">
        <input type='hidden' name='action' value='updated'>

        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>