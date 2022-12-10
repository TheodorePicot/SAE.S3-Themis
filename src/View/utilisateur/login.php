<?php
$hrefCreateAccount = "frontController.php?controller=utilisateur&action=create";
?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row my-5">
        <div class=" col-lg-4 container my-5">
            <form method="get" action="frontController.php">
                <fieldset>
                    <div class="d-flex align-content-center justify-content-center my-5">
                        <h1 class="display-2">
                            Themis
                        </h1>
                    </div>
                    <div class="my-4">
                        <div class="mx-3">
                            <!--                            <h5><label for="login">Pseudo</label></h5>-->
                            <p>
                                <input class="form-control form-control-lg" type="text" placeholder="pseudo"
                                       name="login"
                                       id="login"
                                       required/>
                            </p>
                        </div>
                        <div class="mx-3">
                            <!--                            <h5><label for="mdp">Mot de passe&#42;</label></h5>-->
                            <input class="form-control form-control-lg" type="password" placeholder="mot de passe"
                                   name="mdp" id="mdp" minlength="8"
                                   required/>

                        </div>

                        <input type='hidden' name='action' value='connect'>
                        <input type='hidden' name='controller' value='utilisateur'>
                        <div class="d-flex align-content-center justify-content-center my-5">
                            <button class="btnLogin btn btn-lg btn-dark bg-transparent" type="submit"> Se connecter
                            </button>
                        </div>
                        <p class="d-flex align-content-center justify-content-center">
                            Vous n'avez pas de compte ?&nbsp;
                            <a href="<?= $hrefCreateAccount ?>"> inscrivez-vous!</a>
                        </p>
                    </div>

                </fieldset>
            </form>
        </div>

    </div>
