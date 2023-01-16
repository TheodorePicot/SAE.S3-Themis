<?php $lastSection = end($sections); ?>
<div id="deleteUpdate" class="d-flex align-content-center justify-content-center">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <button class="btn btn-lg btn-primary text-nowrap" type="submit" name="action" value="addSection">+ Ajouter
                une
                section
            </button>
            <?php if ($lastSection != false) ?>
        </div>

        <div class="col-md-12 col-lg-6">
            <input type="hidden" name="lastIdSection" value="<?= $lastSection->getIdSection() ?>">
            <button class="btn btn-lg btn-primary text-nowrap" type="submit" name="action" value="deleteLastSection">-
                Supprimer une section
            </button>
        </div>
    </div>
</div>

<?php
$count = 1;
foreach ($sections as $section) : ?>

    <div class="my-4">
        <h2> Section <?php echo $count ?> </h2>
        <div class="my-1">
            <h5><label>Taille de la section en caractère <small class=text-muted>(optionnel)</small> </label></h5>
                <input class="form-control" type="text" name="nbChar<?=$section->getIdSection() ?>" value="<?=
                $section->getNbChar() == null ? "" :
                    htmlspecialchars($section->getNbChar())
                ?>">

        </div>


        <div class="my-3">
            <h5><label for="titreSection<?= $section->getIdSection() ?>">Titre</label></h5>
            <input class="form-control" type="text" value="<?= htmlspecialchars($section->getTitreSection()) ?>"
                   name="titreSection<?= $section->getIdSection() ?>" id="titreSection<?= $section->getIdSection() ?>"
            />
        </div>

        <div class="my-4">
            <h5><label for="descriptionSection<?= $section->getIdSection() ?>">Description</label></h5>
            <textarea class="form-control" placeholder="" name="descriptionSection<?= $section->getIdSection() ?>"
                      id="descriptionSection<?= $section->getIdSection() ?>" rows="5"
                      cols="40"><?= htmlspecialchars($section->getDescriptionSection()) ?></textarea>
        </div>
    </div>

    <?php
    $count++;
    ?>
<?php endforeach; ?>

