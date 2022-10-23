

<form method="psot" action="frontController.php">
    <fieldset>
        <div class="mx-3 my-3">
        <legend>Création de question</legend>
        <p>
            <label for="titreQuestion">Titre</label> :
            <input type="text" placeholder="Triss ou Yennefer ?" name="titreQuestion" id="titreQuestion" required/>
        </p>

        <p>
            <label for="dateDebutProposition">Date de début des propositions</label> :
            <input type="date" placeholder="JJ/MM/YYYY" name="dateDebutProposition" id="dateDebutProposition" required/>
        </p>

        <p>
            <label for="dateFinProposition">Date de fin des propositions</label> :
            <input type="date" placeholder="JJ/MM/YYYY" name="dateFinProposition" id="dateFinProposition" required/>
        </p>
        <p>
            <label for="dateDebutVote">Date de début du vote</label> :
            <input type="date" placeholder="JJ/MM/YYYY" name="dateDebutVote" id="dateDebutVote" required/>
        </p>
        <p>
            <label for="dateFinVote">Date de fin du vote</label> :
            <input type="date" placeholder="JJ/MM/YYYY" name="dateFinVote" id="dateFinVote" required/>
        </p>

        <input type='hidden' name='action' value='saveQuestion'>

        <p>
            <input type="submit" value="Envoyer"/>
        </p>
        </div>
    </fieldset>
</form>