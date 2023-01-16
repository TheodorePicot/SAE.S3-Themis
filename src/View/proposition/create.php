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


                    <div class="container col-md-12 col-lg-6 my-3">
                        <h3>Choix des Co-Auteurs</h3>
                        <?php require_once __DIR__ . "/../utilisateur/listCoAuteursForCreate.php" ?>
                    </div>

                    <h2 class="my-4"><?= htmlspecialchars($question->getTitreQuestion()) ?>
                    </h2>


                    <div class="shadowBox card card-body border-0">
                        Description : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
                    </div>


                    <div class="my-5">
                        <h3>Titre de votre proposition</h3>
                        <input type="text" class="form-control" placeholder="?" name="titreProposition"
                               id="titreProposition"
                               required/>
                    </div>

                    <div class="my-5">
                        <?php
                        $count = 1;
                        foreach ($sections as $section) : ?>
                            <h3><?= $count ?>. Section <?= $count ?>
                                : <?= htmlspecialchars($section->getTitreSection()) ?></h3>
                            <div class="shadowBox card card-body border-0">
                                <?= htmlspecialchars($section->getDescriptionSection()) ?>
                            </div>

                            <div class="my-4">
                                <h4> Proposition Section <?= $count ?> </h4>

                                <?php
                                if ($section->getNbChar() != null) : ?>
                                    <small class="text-muted">limite de caractère
                                        : <?= htmlspecialchars($section->getNbChar()) ?> </small>
                                <?php endif ?>

                                <textarea class="form-control"
                                          name="descriptionSectionProposition<?= $section->getIdSection() ?>"
                                          id="descriptionSectionProposition<?= $section->getIdSection() ?>" required
                                          rows="5"
                                          cols="40"
                                          <?php if ($section->getNbChar() != null): ?>
                                              maxlength="<?= htmlspecialchars($section->getNbChar()) ?>"
                                          <?php endif ?>></textarea>
                            </div>


                            <?php $count++;
                        endforeach; ?>
                    </div>

                    <input type="hidden" name="action" value="created">
                    <input type="hidden" name="controller" value="proposition">
                    <input type="hidden" name="loginAuteur"
                           value="<?= htmlspecialchars(ConnexionUtilisateur::getConnectedUserLogin()) ?>">
                    <input type="hidden" name="idQuestion" value="<?= $question->getIdQuestion() ?>">

                    <div class="d-flex align-content-center justify-content-center my-3" style="border-radius: 4px">
                        <input class="btn btn-dark " type="submit" value="Soumettre"/>
                    </div>

                </div>
            </div>
        </div>

    </fieldset>
</form>