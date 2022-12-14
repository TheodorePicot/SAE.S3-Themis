<?php

use Themis\Lib\ConnexionUtilisateur;

?>
<form method="get" action="frontController.php">
    <fieldset>

        <div class="d-flex align-content-center justify-content-center">
            <h1>Mise à jour proposition</h1>
        </div>


        <div class='container-fluid'>
            <div class="row mx-5 my-5 gy-4">
                <div class="container-fluid col-md-10 col-lg-10 ">

                    <div class="container col-md-6 col-lg-6 mt-3 mb-5">
                        <h3>Auteurs</h3>
                        <?php require_once __DIR__ . "/../utilisateur/listCoAuteursForUpdate.php" ?>
                    </div>

                    <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>


                    <div class="shadowBox  col-md-10 card card-body border-0" style="background: #C7B198;">
                        Description : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
                    </div>


                    <div class="my-4">
                        <h3><label for="titreProposition">Titre de la proposition</label></h3>
                        <input class="form-control" placeholder="?" value="<?= $proposition->getTitreProposition() ?>"
                               id="titreProposition"
                               name="titreProposition" max="99" maxlength="99" required>
                    </div>


                    <div class="my-4">
                        <?php
                        $count = 1;
                        foreach ($sections as $section) : ?>
                            <h3><?= $count ?>. Section <?= $count ?></h3>
                            <div class="shadowBox col-md-10 card card-body border-0" style="background: #C7B198;">
                                <?= htmlspecialchars($section->getDescriptionSection()) ?>
                            </div>

                            <div class="my-3">

                                <label for="descriptionSectionProposition<?= $section->getIdSection() ?>">
                                    <h4> Propostion Section <?= $count ?> </h4></label>

                                <textarea class="form-control" placeholder=""
                                          name="descriptionSectionProposition<?= $section->getIdSection() ?>"
                                          id="descriptionSectionProposition<?= $section->getIdSection() ?>" required
                                          rows="5"
                                          cols="40"><?= (new \Themis\Model\Repository\SectionPropositionRepository)->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection())->getTexteProposition() ?></textarea>
                            </div>

                            <?php $count++;
                        endforeach; ?>
                    </div>

                    <input type='hidden' name='action' value='updated'>
                    <input type='hidden' name='controller' value='proposition'>
                    <input type='hidden' name='idProposition' value='<?= $proposition->getIdProposition() ?>'>
                    <input type='hidden' name='idQuestion' value='<?= $question->getIdQuestion() ?>'>
                    <input type="hidden" name="loginAuteur"
                           value="<?= $proposition->getLoginAuteur() ?>">
                    <input class="btn btn-dark" type="submit" value="Mettre à jour"/>

                </div>
            </div>
        </div>


    </fieldset>
</form>