<?php

use Themis\Lib\ConnexionUtilisateur;

?>

<form method="post" action="frontController.php?action=created">
    <fieldset>
        <div class="d-flex align-content-center justify-content-center">
            <h1>Créer une Question</h1>
        </div>
        <div class='container-fluid'>
            <div class="row mx-5 gy-4">
                <div class="container col-12 my-3">
                    <h3><label for="titreQuestion" class="form-label">Titre</label></h3>
                    <input type="text" class="form-control" placeholder="?" name="titreQuestion" id="titreQuestion"
                           max="99" maxlength="99"
                           value="<?php if (isset($_SESSION["formData"]["createQuestion"]["titreQuestion"])) echo $_SESSION["formData"]["createQuestion"]["titreQuestion"] ?>"
                           required/>
                </div>

                <div class="container col-12 my-3">
                    <h3><label for="descriptionQuestion" class="form-label">Description</label></h3>
                    <textarea class="form-control input-group-lg" placeholder="description question"
                              name="descriptionQuestion" id="descriptionQuestion"
                              maxlength="700" required rows="5"
                              cols="40"><?php if (isset($_SESSION["formData"]["createQuestion"]["descriptionQuestion"])) echo $_SESSION["formData"]["createQuestion"]["descriptionQuestion"] ?></textarea>
                </div>

                <div class="container col-md-6 col-lg-6 my-3">
                    <h3>Auteurs</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listAuteursForCreate.php" ?>
                </div>
                <div class="container col-md-6 col-lg-6 my-3">
                    <h3>Votants</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listVotantsForCreate.php" ?>
                </div class="container col-md-6 col-lg-6 my-3">


                <div class="col-auto">
                    <h3><label for="autoSizingSelect">Choix du système de vote</label></h3>
                    <select class="form-select"
                            name="systemeVote"
                            id="autoSizingSelect"
                            required>
                        <option value="JugementMajoritaire" <?php if (isset($_SESSION["formData"]["createQuestion"]["systemeVote"]) && $_SESSION["formData"]["createQuestion"]["systemeVote"] == "JugementMajoritaire") echo "selected" ?>>
                            Jugement Majoritaire
                        </option>
                        <option value="ScrutinUninominal" <?php if (isset($_SESSION["formData"]["createQuestion"]["systemeVote"]) && $_SESSION["formData"]["createQuestion"]["systemeVote"] == "ScrutinUninominal") echo "selected" ?>>
                            Scrutin Uninominal
                        </option>
                    </select>

                </div>
            </div>
        </div>

        <!--CALENDRIER-->

        <div class="container-fluid">
            <div class="row mx-5 my-4 gy-2">
                <h3>Calendrier</h3>


                <div class="container col-md-6 col-lg-6 my-4">
                    <h5><label for="dateDebutProposition">Date de début des propositions</label></h5>
                    <input class=form-control type="datetime-local" name="dateDebutProposition"
                           id="dateDebutProposition"
                           value="<?php if (isset($_SESSION["formData"]["createQuestion"]["dateDebutProposition"])) echo $_SESSION["formData"]["createQuestion"]["dateDebutProposition"] ?>"
                           required/>
                </div>

                <div class="container-fluid col-md-6 col-lg-6 my-4">
                    <h5><label for="dateFinProposition">Date de fin des propositions</label></h5>
                    <input class=form-control type="datetime-local" name="dateFinProposition"
                           id="dateFinProposition"
                           value="<?php if (isset($_SESSION["formData"]["createQuestion"]["dateFinProposition"])) echo $_SESSION["formData"]["createQuestion"]["dateFinProposition"] ?>"
                           required/>
                </div>

                <div class="container-fluid col-md-6 col-lg-6 my-4">
                    <h5><label for="dateDebutVote">Date de début du vote</label></h5>
                    <input class=form-control type="datetime-local" name="dateDebutVote"
                           id="dateDebutVote"
                           value="<?php if (isset($_SESSION["formData"]["createQuestion"]["dateDebutVote"])) echo $_SESSION["formData"]["createQuestion"]["dateDebutVote"] ?>"
                           required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6 my-4">
                    <h5><label for="dateFinVote">Date de fin du vote</label></h5>
                    <input class=form-control type="datetime-local" name="dateFinVote"
                           id="dateFinVote"
                           value="<?php if (isset($_SESSION["formData"]["createQuestion"]["dateFinVote"])) echo $_SESSION["formData"]["createQuestion"]["dateFinVote"] ?>"
                           required/>
                </div>

            </div>
            <div class="d-flex align-content-center justify-content-center my-3" style="border-radius: 4px">
                <input class="btn btn-primary text-nowrap" type="submit" value="Continuer"/>
            </div>
        </div>

        <!--        <input type='hidden' name='action' value='created'>-->
        <input type="hidden" name="loginOrganisateur" value="<?= ConnexionUtilisateur::getConnectedUserLogin() ?>">
    </fieldset>
</form>