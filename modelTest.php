<?php

require_once "Model.php";

echo phpinfo();

// On affiche un attribut de PDO pour vérifier  que la connexion est bien établie.
// Cela renvoie par ex. "webinfo.iutmontp.univ-montp2.fr via TCP/IP"
// mais surtout pas de message d'erreur
// SQLSTATE[HY000] [1045] Access denied for user ... (mauvais mot de passe)
// ou
// SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed (mauvais hostname)
$model = new Model();
echo $model->getPdo()->getAttribute(PDO::ATTR_CONNECTION_STATUS);


