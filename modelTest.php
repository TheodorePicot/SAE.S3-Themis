<?php
require_once 'src/Model/DatabaseConnection.php';
$model = new Model();
echo $model->getPdo()->getAttribute(PDO::ATTR_CONNECTION_STATUS);


