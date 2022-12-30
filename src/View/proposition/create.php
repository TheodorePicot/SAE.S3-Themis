<?php

use Themis\Lib\ConnexionUtilisateur;

?>
<form method="post" action="frontController.php" class="needs-validation" novalidate>
    <fieldset>

        <div class="d-flex align-content-center justify-content-center">
            <h1>Creer une proposition</h1>
        </div>

        <div class="container-fluid">
            <div class="row mx-5 my-5 gy-4">
                <div class="container-fluid col-md-10 col-lg-10 ">

                    <div class="container col-md-6 col-lg-6 my-3">
                        <h3>Choix des Co-Auteurs</h3>
                        <?php require_once __DIR__ . "/../utilisateur/listCoAuteursForCreate.php" ?>
                    </div>

                    <h2 class="my-4"><label for="titreQuestion"
                                            class="form-label"><?= htmlspecialchars($question->getTitreQuestion()) ?></label>
                    </h2>


                    <div class="shadowBox col-md-10 card card-body border-0">
                        Description : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
                    </div>


                    <div class="my-5">
                        <h3><label for="titreQuestion" class="form-label">Titre de votre proposition</label></h3>
                        <input type="text" class="form-control" placeholder="?" name="titreProposition"
                               id="titreProposition"
                               max="99" maxlength="99"
                               required/>
                    </div>

                    <div class="my-5">
                        <?php
                        $count = 1;
                        foreach ($sections as $section) : ?>
                            <h3><?= $count ?>. Section <?= $count ?> : <?= $section->getTitreSection() ?></h3>
                            <div class="shadowBox col-md-10 card card-body border-0">
                                <?= htmlspecialchars($section->getDescriptionSection()) ?>
                            </div>

                            <div class="my-4">
                                <label for="descriptionSectionProposition<?= $section->getIdSection() ?>">
                                    <h4> Propostion Section <?= $count ?> </h4></label>

                                <textarea class="form-control" placeholder=""
                                          name="descriptionSectionProposition<?= $section->getIdSection() ?>"
                                          id="descriptionSectionProposition<?= $section->getIdSection() ?>" required
                                          rows="5"
                                          cols="40"></textarea>
                            </div>


                            <?php $count++;
                        endforeach; ?>
                    </div>

                    <input type="hidden" name="action" value="created">
                    <input type="hidden" name="controller" value="proposition">
                    <input type="hidden" name="loginAuteur"
                           value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
                    <input type="hidden" name="idQuestion" value="<?= $question->getIdQuestion() ?>">

                    <div class="d-flex align-content-center justify-content-center my-3" style="border-radius: 4px">
                        <input class="btn btn-dark " type="submit" value="Soumettre"/>
                    </div>

                </div>
            </div>
        </div>

    </fieldset>
</form>