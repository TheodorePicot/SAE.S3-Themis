<form method="get" action="frontController.php">
    <fieldset>
        <div class="d-flex align-content-center justify-content-center">
            <h1>Mise à jour de la question</h1>
        </div>

        <div class='container-fluid'>
            <div class="row mx-5 my-5 gy-4">
                <div class="container-fluid col-md-6 col-lg-6">
                    <h3><label for="titreQuestion" class="form-label">Titre</label></h3>
                    <input class="form-control" type="text" placeholder="?"
                           value="<?= htmlspecialchars($question->getTitreQuestion()) ?>"
                           name="titreQuestion" id="titreQuestion" max="99" maxlength="99" required/>

                </div>

                <div class="container-fluid col-md-6 col-lg-6">
                    <h3>Auteurs</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listAuteursForUpdate.php" ?>
                </div>

                <div class="container-fluid col-md-6 col-lg-6">
                    <h3><label for="descriptionQuestion" class="form-label">Description</label></h3>
                    <textarea class="form-control" placeholder="Decrire la question" name="descriptionQuestion"
                              id="descriptionQuestion"
                              required rows="5" cols="40"
                              maxlength="700"><?= htmlspecialchars($question->getDescriptionQuestion()) ?></textarea>
                </div>

                <div class="container-fluid col-md-6 col-lg-6 my-3">
                    <h3>Votants</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listVotantsForUpdate.php" ?>
                </div>


            </div>
        </div>

        <!--CALENDRIER-->

        <div class="container-fluid">
            <div class="row mx-5 my-4 gy-2">
                <h2>Calendrier</h2>
                <div class="container-fluid col-md-6 col-lg-6 my-4">
                    <h5><label for="dateDebutProposition">Date de début des propositions</label></h5>
                    <input class="form-control" type="date" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateDebutProposition()) ?>"
                           name="dateDebutProposition" id="dateDebutProposition" required/>

                </div>
                <div class="container-fluid col-md-6 col-lg-6 my-4">

                    <h5><label for="dateFinProposition">Date de fin des propositions</label></h5>
                    <input class="form-control" type="date" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateFinProposition()) ?>"
                           name="dateFinProposition" id="dateFinProposition" required/>

                </div>

                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateDebutVote">Date de début du vote</label></h5>
                    <input class="form-control" type="date" placeholder="JJ/MM/YYYY"
                           value="<?= htmlspecialchars($question->getDateDebutVote()) ?>"
                           name="dateDebutVote" id="dateDebutVote" required/>

                </div>
                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateFinVote">Date de fin du vote</label></h5>
                    <input class="form-control" type="date" placeholder="JJ/MM/YYYY"
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
                    <input type='hidden' name='action' value='updated'>

                    <?php require_once __DIR__ . "/../section/listByQuestionForUpdate.php" ?>

                </div>
                <div class="col-12 d-flex align-content-center justify-content-center">
                    <input class="btn btn-lg btn-dark" type="submit" value="Envoyer"/>
                </div>

            </div>


        </div>


    </fieldset>
</form>

