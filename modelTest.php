<?php
$pdo = new PDO('pgsql:host=themis-db-instance.cnowxclkulrh.eu-west-3.rds.amazonaws.com;port=5432;dbname=themis;user=themis;password=Themis2022');
echo $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
$pdo->query("SELECT t.* FROM " . 'themis."Questions" t WHERE "idQuestion"=1');


