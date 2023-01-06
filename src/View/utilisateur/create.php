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

                            <p>
                                <input class="form-control form-control-lg <?= isset($_GET["invalidLogin"]) ? "is-invalid" : "" ?>"
                                       type="text" placeholder="Pseudo" name="login"
                                       id="login"
                                       value="<?php if (isset($_SESSION["createUtilisateur"]["login"])) echo $_SESSION["createUtilisateur"]["login"] ?>"
                                       required/>
                            </p>
                        </div>


                        <div class="mx-3">
                            <p>
                                <input class="form-control form-control-lg" type="text"
                                       placeholder="Email"
                                       name="adresseMail"
                                       id="adresseMail"
                                       value="<?php if (isset($_SESSION["createUtilisateur"]["adresseMail"])) echo $_SESSION["createUtilisateur"]["adresseMail"] ?>"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3">
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="Nom" name="Nom"
                                       id="nom"
                                       value="<?php if (isset($_SESSION["createUtilisateur"]["nom"])) echo $_SESSION["createUtilisateur"]["nom"] ?>"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3">
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="Prénom" name="Prenom"
                                       id="prenom"
                                       value="<?php if (isset($_SESSION["createUtilisateur"]["prenom"])) echo $_SESSION["createUtilisateur"]["prenom"] ?>"
                                       required/>
                            </p>
                        </div>
                        <div class="mx-3 ">
                            <p>
                                <input class="form-control form-control-lg <?= isset($_GET["invalidPswd"]) ? "is-invalid" : "" ?>"
                                       type="password" name="mdp" id="mdp" placeholder="Mot de passe"
                                       minlength="8"
                                       required/>
                            </p>
                        </div>

                        <div class="mx-3 ">
                            <p>
                                <input class="form-control form-control-lg <?= isset($_GET["invalidPswd"]) ? "is-invalid" : "" ?>"
                                       type="password" name="mdpConfirmation" placeholder="Confirmation du mot de passe"
                                       id="mdpConfirmation"
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


