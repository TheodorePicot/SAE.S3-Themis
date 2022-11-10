<form method="get" action="frontController.php">
    <fieldset>
        <div id='containerFormulaire' class='container text-center my-5' style="border: 2px solid">
            <h2>Création Question</h2>
            <p>
                <label for="titreQuestion">Titre</label> :
                <input type="text" placeholder="?" name="titreQuestion" id="titreQuestion" max="99" maxlength="99" required/>
            </p>

            <p>
                <label for="descriptionQuestion">Description</label> :
                <textarea placeholder="Votre question ici" name="descriptionQuestion" id="descriptionQuestion"
                          maxlength="700" required rows="5" cols="40"></textarea>
            </p>

            <h3>Auteurs et Votants</h3>



            <h3>Calendrier</h3>

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

            <input type='hidden' name='action' value='created'>

            <p>
                <input type="submit" value="Envoyer"/>
            </p>
        </div>
    </fieldset>
</form>