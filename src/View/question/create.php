<form method="get" action="frontController.php" xmlns="http://www.w3.org/1999/html">
    <fieldset>
        <div class="d-flex align-content-center justify-content-center">
            <h1>Creer une Question</h1>
        </div>

        <div class='container-fluid'>
            <div class="row mx-5 my-4 gy-4">
                <div class="container col-md-6 col-lg-6">
                    <h3><label for="titreQuestion" class="form-label">Titre</label></h3>
                    <input type="text" class="form-control" placeholder="?" name="titreQuestion" id="titreQuestion"
                           max="99" maxlength="99"
                           required/>
                </div>

                <div class="container col-md-6 col-lg-6">
                    <h3>Auteurs</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listAuteursForCreate.php" ?>
                </div>

                <div class="container col-md-6 col-lg-6">
                    <h3><label for="descriptionQuestion" class="form-label">Description</label></h3>
                    <textarea class="form-control input-group-lg" placeholder="description question"
                              name="descriptionQuestion" id="descriptionQuestion"
                              maxlength="700" required rows="5" cols="40"></textarea>
                </div>


                <div class="container col-md-6 col-lg-6 my-3">
                    <h3>Votants</h3>
                    <?php require_once __DIR__ . "/../utilisateur/listVotantsForCreate.php" ?>
                </div>


            </div>
        </div>

        <!--CALENDRIER-->

        <div class="container-fluid">
            <div class="row mx-5 my-4 gy-2">
                <h2>Calendrier</h2>
                <div class="container col-md-6 col-lg-6 my-4">
                    <h5><label for="dateDebutProposition">Date de début des propositions</label></h5>
                    <input class=form-control type="date" placeholder="JJ/MM/YYYY" name="dateDebutProposition"
                           id="dateDebutProposition" required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6 my-4">

                    <h5><label for="dateFinProposition">Date de fin des propositions</label></h5>
                    <input class=form-control type="date" placeholder="JJ/MM/YYYY" name="dateFinProposition"
                           id="dateFinProposition" required/>
                </div>

                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateDebutVote">Date de début du vote</label></h5>
                    <input class=form-control type="date" placeholder="JJ/MM/YYYY" name="dateDebutVote"
                           id="dateDebutVote"
                           required/>
                </div>
                <div class="container-fluid col-md-6 col-lg-6">
                    <h5><label for="dateFinVote">Date de fin du vote</label></h5>
                    <input class=form-control rol type="date" placeholder="JJ/MM/YYYY" name="dateFinVote"
                           id="dateFinVote"
                           required/>
                </div>
            </div>
            <div class="btn mx-5" style="border-radius: 4px">
                <input class="btn btn-dark" type="submit" value="Continuer"/>
            </div>
        </div>

        <input type='hidden' name='action' value='created'>


    </fieldset>
</form>