<div class="container-fluid">
    <div class="row my-5 ">
        <div class=" col-md-12 offset-lg-4 col-lg-4 my-4">
            <form method="post" action="frontController.php">
                <fieldset>
                    <div class="d-flex align-content-center justify-content-center">
                        <h1 class="display-3">Themis</h1>
                    </div>
                    <div class="my-4">
                        <input type="hidden" name="controller" value="utilisateur">
                        <input type="hidden" name="action" value="created">

                        <div class="mx-3">
                            <h5><label for="login">Login&#42;</label></h5>

                            <input class="form-control form-control-lg <?= isset($_REQUEST["invalidLogin"]) ? "is-invalid" : "" ?>"
                                   type="text" name="login"
                                   id="login"
                                   value="<?php if (isset($_SESSION["formData"]["createUtilisateur"]["login"])) echo $_SESSION["formData"]["createUtilisateur"]["login"] ?>"
                                   required/>

                        </div>


                        <div class="mx-3 my-2">
                            <h5><label for="adresseMail">Email&#42;</label></h5>

                            <input class="form-control form-control-lg" type="text"
                                   name="adresseMail"
                                   id="adresseMail"
                                   value="<?php if (isset($_SESSION["formData"]["createUtilisateur"]["adresseMail"])) echo $_SESSION["formData"]["createUtilisateur"]["adresseMail"] ?>"
                                   required/>

                        </div>

                        <div class="mx-3 my-2">
                            <h5><label for="nom">Nom&#42;</label></h5>

                            <input class="form-control form-control-lg" type="text" name="nom"
                                   id="nom"
                                   value="<?php if (isset($_SESSION["formData"]["createUtilisateur"]["nom"])) echo $_SESSION["formData"]["createUtilisateur"]["nom"] ?>"
                                   required/>

                        </div>

                        <div class="mx-3 my-2">
                            <h5><label for="prenom">Prénom&#42;</label></h5>

                            <input class="form-control form-control-lg" type="text" name="prenom"
                                   id="prenom"
                                   value="<?php if (isset($_SESSION["formData"]["createUtilisateur"]["prenom"])) echo $_SESSION["formData"]["createUtilisateur"]["prenom"] ?>"
                                   required/>

                        </div>
                        <div class="mx-3 my-2">
                            <h5><label for="dateNaissance">Date de naissance</label></h5>

                            <input class="form-control form-control-lg" type="date" name="dateNaissance"
                                   id="dateNaissance"
                                   value="<?php if (isset($_SESSION["formData"]["createUtilisateur"]["dateNaissance"])) echo $_SESSION["formData"]["createUtilisateur"]["dateNaissance"] ?>"/>

                        </div>

                        <div class="mx-3 my-2">
                            <h5><label for="mdp">Mot de passe&#42;</label></h5>

                            <input class="form-control form-control-lg <?= isset($_REQUEST["invalidPswd"]) ? "is-invalid" : "" ?>"
                                   type="password" name="mdp" id="mdp"
                                   minlength="8"
                                   required/>

                        </div>

                        <div class="mx-3 my-2">
                            <h5><label for="mdpConfirmation">Confirmation mot de passe&#42;</label></h5>

                            <input class="form-control form-control-lg <?= isset($_REQUEST["invalidPswd"]) ? "is-invalid" : "" ?>"
                                   type="password" name="mdpConfirmation"
                                   id="mdpConfirmation"
                                   minlength="8"
                                   required/>

                        </div>

                        <?php use Themis\Lib\ConnexionUtilisateur;

                        if (ConnexionUtilisateur::isAdministrator()) :?>
                            <div class="mx-3 ">
                                <h5><label class="InputAddOn-item" for="estAdmin_id">Administrateur</label></h5>

                                <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin"
                                       id="estAdmin_id">

                            </div>
                            <div class="mx-3 my-2">
                                <h5><label class="InputAddOn-item" for="estOrganisateur">Organisateur</label></h5>
                                <input class="InputAddOn-field" type="checkbox" placeholder=""
                                       name="estOrganisateur" id="estOrganisateur">

                            </div>
                        <?php endif ?>
                        <div class="d-flex align-content-center justify-content-center my-5">

                            <input class="btn btn-primary" type="submit" value="S'enregistrer"/>
                        </div>

                    </div>
                </fieldset>
            </form>

        </div>
    </div>

</div>
