<?php
$dateTmp = date("d-m-y h:i:s");
echo date("d-m-y H:i:s", strtotime($dateTmp . "4 hours"));