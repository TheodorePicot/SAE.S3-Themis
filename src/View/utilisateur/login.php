<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row my-5">

        <div class="col-lg-4">
        </div>

        <div class="shadowBox col-lg-4 container my-4 card-body border-0 rounded-4" style="background: #C7B198;">
            <form method="get" action="frontController.php">
                <fieldset>
                    <div class="d-flex align-content-center justify-content-center my-1">
                        <h2>
                            Se connecter
                        </h2>
                    </div>
                    <div class="my-4">
                        <div class="mx-3">
                            <h5><label for="login">Login</label></h5>
                            <p>
                                <input class="form-control" type="text" placeholder="dupontpaul1610" name="login"
                                       id="login"
                                       required/>
                            </p>
                        </div>
                        <div class="mx-3">
                            <h5><label for="mdp">Mot de passe&#42;</label></h5>

                            <input class="form-control" type="password" name="mdp" id="mdp" minlength="8"
                                   required/>

                        </div>

                        <input type='hidden' name='action' value='connecter'>
                        <input type='hidden' name='controller' value='utilisateur'>
                        <div class="d-flex align-content-center justify-content-center my-5">
                            <button class="btn btn-dark" type="submit">  Se connecter </button>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <div class="col-lg-4">
        </div>
    </div>
