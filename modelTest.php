<?php
$dateTmp = date("d-m-y h:i:s");
//echo date("d-m-y H:i:s", strtotime($dateTmp . "4 hours"));
//echo date("d-m-Y H:i:s", strtotime($dateTmp . "2 days"));
$date=date_create();
//echo $date->format("d-m-y H:i:s");
//$currentDate = new DateTime();
//echo $currentDate->format('d-m-y H:i:s');
date_add($date,date_interval_create_from_date_string("1 day"));
echo date_create()->format("d-m-y H:i:s");