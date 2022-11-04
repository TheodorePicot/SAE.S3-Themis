<?php
$lastSection = end($sections);
foreach ($sections as $section) : ?>
    <p>
        <label for="titreSection<?= $section->getIdSection() ?>">Le titre de la section</label> :
        <input type="text" value="<?= $section->getTitreSection() ?>"
               name="titreSection<?= $section->getIdSection() ?>" id="titreSection<?= $section->getIdSection() ?>"
               required/>
    </p>

    <p>
        <label for="descriptionSection<?= $section->getIdSection() ?>"> La description de la section</label> :
        <textarea placeholder="" name="descriptionSection<?= $section->getIdSection() ?>"
                  id="descriptionSection<?= $section->getIdSection() ?>" required rows="5"
                  cols="40"><?= $section->getDescriptionSection() ?></textarea>
    </p>
<?php endforeach; ?>
<a href="frontController.php?action=addSection&idQuestion=<?= $_GET['idQuestion'] ?>">Ajouter section</a>

<a href="frontController.php?action=deleteLastSection&idQuestion=<?= $_GET['idQuestion'] ?>&idSection=<?= $lastSection->getIdSection() ?>">Supprimer
    section</a>
