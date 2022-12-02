<?php
$count = 1;
foreach ($sections as $section) : ?>

    <div class="my-4">
        <h2> Section <?php echo $count ?> </h2>
        <h5><label for="titreSection<?= $section->getIdSection() ?>">Titre</label></h5>
        <input class="form-control" type="text" value="<?= htmlspecialchars($section->getTitreSection()) ?>"
               name="titreSection<?= $section->getIdSection() ?>" id="titreSection<?= $section->getIdSection() ?>"
               required/>
        <div class="my-4">
            <h5><label for="descriptionSection<?= $section->getIdSection() ?>">Description</label></h5>
            <textarea class="form-control" placeholder="" name="descriptionSection<?= $section->getIdSection() ?>"
                      id="descriptionSection<?= $section->getIdSection() ?>" required rows="5"
                      cols="40"><?= htmlspecialchars($section->getDescriptionSection()) ?></textarea>
        </div>
    </div>

    <?php $count++ ?>
<?php endforeach; ?>

