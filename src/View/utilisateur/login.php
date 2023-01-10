<?php
$hrefCreateAccount = "frontController.php?controller=utilisateur&action=create";
?>
<div class="container">
    <div class="row my-5">
        <div class=" col-md-8 col-lg-4 container my-5">
            <form method="post" action="frontController.php">
                <fieldset>
                    <div class="d-flex align-content-center justify-content-center my-5">
                        <h1 class="display-2">
                            Themis
                        </h1>
                    </div>
                    <div class="my-4">
                        <div class="mx-3">


                                <input class="form-control form-control-lg <?= isset($_REQUEST["invalidLogin"]) ? "is-invalid" : "" ?>" type="text" placeholder="pseudo"
                                       name="login"
                                       value="<?php if (isset($_SESSION["formData"]["connection"]["login"])) echo $_SESSION["formData"]["connection"]["login"] ?>"
                                       id="login"
                                       required/>

                        </div>
                        <div class="mx-3 my-2">
                            <input class="form-control form-control-lg <?= isset($_REQUEST["invalidPswd"]) ? "is-invalid" : "" ?>" type="password" placeholder="mot de passe"
                                   name="mdp" id="mdp" minlength="8"
                                   required/>

                        </div>

                        <input type='hidden' name='action' value='connect'>
                        <input type='hidden' name='controller' value='utilisateur'>
                        <div class="d-flex align-content-center justify-content-center my-5">
                            <button class="btn btn-lg btn-primary" type="submit">Se connecter
                            </button>
                        </div>
                        <p class="d-flex align-content-center justify-content-center">
                            Vous n'avez pas de compte ?&nbsp;
                            <a href="<?= $hrefCreateAccount ?>"> inscrivez-vous!</a>

                    </div>

                </fieldset>
            </form>
        </div>

    </div>
</div>