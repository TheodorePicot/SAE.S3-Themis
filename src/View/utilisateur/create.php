<div class="container-fluid">
    <div class="row my-5 mx-5">
        <div class="shadowBox col-md-12 offset-lg-3 col-lg-6 my-4">
            <div class="card-body border-0 rounded-4" style="background: #C7B198;">
                <form method="get" action="frontController.php">
                    <fieldset>
                        <div class="d-flex align-content-center justify-content-center">
                            <h1> Bienvenue sur Themis</h1>
                        </div>
                        <div class="my-4">
                            <input type="hidden" name="controller" value="utilisateur">
                            <input type="hidden" name="action" value="created">

                            <div class="mx-3">
                                <h5><label for="login">Login</label></h5>
                                <p>
                                    <input class="form-control" type="text" placeholder="Paul16" name="login"
                                           id="login"
                                           required/>
                                </p>
                            </div>


                            <div class="mx-3">
                                <h5><label for="adresseMail">Email</label></h5>
                                <p>
                                    <input class="form-control" type="text" placeholder="dupontpaul1610@gmail.com"
                                           name="adresseMail"
                                           id="adresseMail"
                                           required/>
                                </p>
                            </div>

                            <div class="mx-3">
                                <h5><label for="nom">Nom</label></h5>
                                <p>
                                    <input class="form-control" type="text" placeholder="Dupont" name="nom" id="nom"
                                           required/>
                                </p>
                            </div>

                            <div class="mx-3">
                                <h5><label for="prenom">Prénom</label></h5>
                                <p>
                                    <input class="form-control" type="text" placeholder="Paul" name="prenom" id="prenom"
                                           required/>
                                </p>
                            </div>
                            <div class="mx-3">
                                <h5><label for="dateNaissance">Date de naissance</label></h5>
                                <p>
                                    <input class="form-control" type="date" name="dateNaissance" id="dateNaissance"
                                           required/>
                                </p>
                            </div>

                            <div class="mx-3 ">
                                <h5><label for="mdp">Mot de passe&#42;</label></h5>
                                <p>
                                    <input class="form-control" type="password" name="mdp" id="mdp" minlength="8"
                                           required/>
                                </p>
                            </div>

                            <div class="mx-3 ">
                                <h5><label for="mdp2">Confirmation mot de passe&#42;</label></h5>
                                <p>
                                    <input class="form-control" type="password" name="mdp2" id="mdp2" minlength="8"
                                           required/>
                                </p>
                            </div>

                            <div class="d-flex align-content-center justify-content-center my-5">

                                <input class="btn btn-dark" type="submit" value="S'enregistrer"/>
                            </div>

                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-md-1 col-lg-4">

            </div>
        </div>
    </div>


