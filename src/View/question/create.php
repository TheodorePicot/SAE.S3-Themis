<form method="get" action="frontController.php">
    <fieldset>
        <legend>Mon formulaire :</legend>

        <input type='hidden', name='action', value='created'>

        <p>
            <label for="immat_id">Titre</label> :
            <input type="text" placeholder="test question?" name="immatriculation" id="immat_id" required/>
        </p>

        <p>
            <label for="marque_id">Date de début des propositions</label> :
            <input type="text" placeholder="JJ/MM/YYYY" name="marque" id="marque_id" required/>
        </p>

        <p>
            <label for="couleur_id">Date de début des propositions</label> :
            <input type="text" placeholder="JJ/MM/YYYY" name="couleur" id="couleur_id" required/>
        </p>
        <p>
            <label for="nbSieges_id">Date de début du vote</label> :
            <input type="text" placeholder="JJ/MM/YYYY" name="siege" id="nbSieges_id" required/>
        </p>
        <p>
            <label for="nbSieges_id">Date de début du vote</label> :
            <input type="text" placeholder="JJ/MM/YYYY" name="siege" id="nbSieges_id" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>