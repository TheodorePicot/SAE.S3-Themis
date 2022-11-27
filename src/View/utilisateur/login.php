<div class="container">
    <div class="row my-5">

        <div class="col-lg-4">
        </div>

        <div class="col-lg-4 container my-4 card-body border-0 rounded-4" style="background: #C7B198;">
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
                            <h5><label for="password">Mot de passe</label></h5>

                                <input class="form-control" type="password" name="password" id="password" minlength="8"
                                       required/>

                        </div>
                            <input hidden type="submit" value="Envoyer">
                        <div class="d-flex align-content-center justify-content-center my-5">
                            <a class="btn btn-dark" href="frontController.php?controller=utilisateur&action=create">
                                S'incrire</a>

                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <div class="col-lg-4">
        </div>
    </div>

    <div class="container-fluid">