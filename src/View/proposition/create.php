<form method="get" action="frontController.php">
    <fieldset>
        <div id='containerFormulaire' class='container text-center my-5' style="border: 2px solid">
            <h2>Création Proposition</h2>
            <p>
                <label for="titreQuestion">Titre</label> :
                <input type="text" placeholder="?" value="<?= $question->getTitreQuestion() ?>"
                       name="titreQuestion" id="titreQuestion" max="99" maxlength="99" required/>
            </p>

            <p>
                <label for="descriptionQuestion">Description</label> :
                <textarea placeholder="Decrire la question" name="descriptionQuestion"
                          id="descriptionQuestion"
                          required rows="5" cols="40"
                          maxlength="700"><?= $question->getDescriptionQuestion() ?></textarea>
            </p>


            <h3>Sections</h3>

            <?php foreach ($sections as $section) :
                $titreSectionPropositionHTML = htmlspecialchars($sections->getTitreSection());
                $questionInURL = rawurlencode($question->getIdQuestion());
                $hrefRead = "frontController.php?action=create&idProposition=" . $questionInURL;
                ?>

                <p>
                    <label for="titreSection">Titre</label> :
                    <input type="text" placeholder="?" value="<?= $titreSectionPropositionHTML ?>"
                           name="titreSection" id="titreSection" max="99" maxlength="99" required/>
                </p>

                <p>
                    <label for="descriptionSectionProposition">Description</label> :
                    <textarea placeholder="Decrire la sectionProposition" name="descriptionSectionProposition"
                              id="descriptionSectionProposition"
                              required rows="5" cols="40"
                              maxlength="700"></textarea>
                </p>

            <?php endforeach; ?>

            <input type='hidden' name='action' value='created'>

            <p>
                <input type="submit" value="Soumettre"/>
            </p>
        </div>
    </fieldset>
</form>