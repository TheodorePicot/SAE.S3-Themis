<?php

use Themis\Lib\ConnexionUtilisateur;

?>
<form method="post" action="frontController.php">
    <fieldset>
        <div class="d-flex align-content-center justify-content-center">
            <h1><?= $message ?></h1>
        </div>

        <div class='container-fluid'>
            <div class="row mx-5 gy-4">
                <div class="container-fluid col-12">
                    <h3><label for="titreQuestion" class="form-label">Titre</label></h3>
                    <input class="form-control" type="text" placeholder="?"
                           value="<?= htmlspecialchars($question->getTitreQuestion()) ?>"
                           name="titreQuestion" id="titreQuestion" maxlength="200" required/>

                </div>

                <div class="container-fluid col-12">
                    <h3><label for="descriptionQuestion" class="form-label">Description</label></h3>
                    <textarea class="form-control" placeholder="Decrire la question" name="descriptionQuestion"
                              id="descriptionQuestion"
                              required rows="5" cols="40"
                              maxlength="700"><?= htmlspecialchars($question->getDescriptionQuestion()) ?></textarea>
                </div>


                <div class="container col-md-6 col-lg-6 mt-3 mb-5">
                    <h3>Auteurs</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listAuteursForUpdate.php" ?>
                </div>

                <div class="container col-md-6 col-lg-6 mt-3 mb-5">
                    <h3>Votants</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listVotantsForUpdate.php" ?>
                </div>

                <h3><label for="systemeVote" class="form-label">Choix du système de vote</label></h3>

                <div class="col-auto">
                    <select class="form-select h-100" name="systemeVote" id="autoSizingSelect" required>
                        <option value="JugementMajoritaire" <?php if ($question->getSystemeVote() == "JugementMajoritaire") echo "selected" ?>>Jugement Majoritaire</option>
                        <option value="ScrutinUninominal" <?php if ($question->getSystemeVote()  == "ScrutinUninominal") echo "selected" ?>>Scrutin Uninominal</option>
                    </select>
                </div>
            </div>
        </div>

        <!--CALENDRIER-->

        <div class="container-fluid">
            <div class="row mx-5 my-4 gy-2">
                <h2>Calendrier</h2>
                <div class="container-fluid col-md-6 col-lg-6 my-4">
                    <h5><label for="dateDebutProposition">Date de début des propositions</label></h5>
                    <input class="form-control" type="datetime-local" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateDebutProposition()) ?>"
                           name="dateDebutProposition" id="dateDebutProposition" required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6 my-4">

                    <h5><label for="dateFinProposition">Date de fin des propositions</label></h5>
                    <input class="form-control" type="datetime-local" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateFinProposition()) ?>"
                           name="dateFinProposition" id="dateFinProposition" required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateDebutVote">Date de début du vote</label></h5>
                    <input class="form-control" type="datetime-local" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateDebutVote()) ?>"
                           name="dateDebutVote" id="dateDebutVote" required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateFinVote">Date de fin du vote</label></h5>
                    <input class="form-control" type="datetime-local" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateFinVote()) ?>"
                           name="dateFinVote"
                           id="dateFinVote" required/>
                </div>
            </div>
        </div>

        <div class='container-fluid'>
            <div class="row mx-5 my-4 gy-2">
                <div class="container-fluid col-md-6 col-lg-12">


                    <input type="hidden" name="idQuestion" value="<?= htmlspecialchars($question->getIdQuestion()) ?>">
                    <input type="hidden" name="loginOrganisateur"
                           value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
                    <?php if(isset($_REQUEST["isInCreation"])) : ?>
                        <input type="hidden" name="isInCreation" value="isInCreation">
                    <?php endif ?>
                    <?php require_once __DIR__ . "/../section/listByQuestionForUpdate.php" ?>
                </div>

                <?php if(isset($_REQUEST["isInCreation"])) : ?>
                    <input type="hidden" name="isInCreation" value="isInCreation">
                    <div class="col-12 d-flex align-content-center justify-content-center">
                        <button class="btn btn-lg btn-primary text-nowrap" type="submit" name="action" value="updated">Créer</button>
                    </div>
                <?php else : ?>
                <div class="col-12 d-flex align-content-center justify-content-center">
                    <button class="btn btn-lg btn-primary text-nowrap" type="submit" name="action" value="updated">Mettre à Jour</button>
                </div>
                <?php endif ?>
            </div>
        </div>
    </fieldset>
</form>

