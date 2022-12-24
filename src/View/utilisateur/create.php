

<div class="container-fluid">
    <div class="row my-5 ">
        <div class=" col-md-12 offset-lg-4 col-lg-4 my-4">
            <form method="get" action="frontController.php">
                <fieldset>
                    <div class="d-flex align-content-center justify-content-center">
                        <h1 class="display-3">Themis</h1>
                    </div>
                    <div class="my-4">
                        <input type="hidden" name="controller" value="utilisateur">
                        <input type="hidden" name="action" value="created">

                        <div class="mx-3">
                            <h5><label for="login">Login</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="Paul16" name="login"
                                       id="login"
                                       required/>
                            </p>
                        </div>


                        <div class="mx-3">
                            <h5><label for="adresseMail">Email&#42;</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="dupontpaul1610@gmail.com"
                                       name="adresseMail"
                                       id="adresseMail"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3">
                            <h5><label for="nom">Nom</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="Dupont" name="nom" id="nom"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3">
                            <h5><label for="prenom">Prénom</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="Paul" name="prenom" id="prenom"
                                       required/>
                            </p>
                        </div>
                        <div class="mx-3">
                            <h5><label for="dateNaissance">Date de naissance</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="date" name="dateNaissance" id="dateNaissance"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3 ">
                            <h5><label for="mdp">Mot de passe&#42;</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="password" name="mdp" id="mdp" minlength="8"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3 ">
                            <h5><label for="mdpConfirmation">Confirmation mot de passe&#42;</label></h5>
                            <p>
                                <input class="form-control form-control-lg" type="password" name="mdpConfirmation" id="mdpConfirmation"
                                       minlength="8"
                                       required/>
                            </p>
                        </div>

                        <?php use Themis\Lib\ConnexionUtilisateur;

                        if (ConnexionUtilisateur::isAdministrator()) :?>
                            <div class="mx-3 ">
                                <h5><label class="InputAddOn-item" for="estAdmin_id">Administrateur</label></h5>
                                <p>
                                    <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin"
                                           id="estAdmin_id">
                                </p>
                            </div>
                            <div class="mx-3 ">
                                <h5><label class="InputAddOn-item" for="estOrganisateur">Organisateur</label></h5>
                                <p>
                                    <input class="InputAddOn-field" type="checkbox" placeholder=""
                                           name="estOrganisateur" id="estOrganisateur">
                                </p>
                            </div>
                        <?php endif ?>
                        <div class="d-flex align-content-center justify-content-center my-5">

                            <input class="btn btn-dark" type="submit" value="S'enregistrer"/>
                        </div>

                    </div>
                </fieldset>
            </form>

            <div class="col-md-1 col-lg-4">

            </div>
        </div>
    </div>


