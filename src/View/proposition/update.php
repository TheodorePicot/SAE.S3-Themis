<form method="get" action="frontController.php">
    <fieldset>
        <div id='containerFormulaire' class='container text-center my-5' style="border: 2px solid">
            <h2>Création Proposition</h2>

            <div class="containerQuestionRead d-flex">
                <div class='container my-5'>
                    <ul style='list-style: none'>
                        <li>
                            <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>
                        </li>
                        <li>
                            Description de la question : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
                        </li>
                    </ul>
                </div>
            </div>

            <p>
                <label for="titreProposition">TitreProposition</label> :
                <input placeholder="?" value="<?= $proposition->getTitreProposition() ?>" id="titreProposition"
                       name="titreProposition" max="99" maxlength="99" required>
            </p>

            <h3>Sections</h3>

            <?php
            $count = 1;
            foreach ($sections as $section) : ?>
                <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
                <p><?= htmlspecialchars($section->getDescriptionSection()) ?></p>

                <p>
                    <label for="descriptionSectionProposition<?= $section->getIdSection() ?>"> Votre
                        proposition </label> :
                    <textarea placeholder="" name="descriptionSectionProposition<?= $section->getIdSection() ?>"
                              id="descriptionSectionProposition<?= $section->getIdSection() ?>" required rows="5"
                              cols="40"><?=(new \Themis\Model\Repository\SectionPropositionRepository)->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection())->getTexteProposition()?></textarea>
                </p>

                <?php $count++;
            endforeach; ?>

            <input type='hidden' name='action' value='updated'>
            <input type='hidden' name='controller' value='proposition'>
            <input type='hidden' name='idQuestion' value='<?= $question->getIdQuestion() ?>'>

            <p>
                <input type="submit" value="Soumettre"/>
            </p>
        </div>
    </fieldset>
</form>