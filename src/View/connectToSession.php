<?php

use Themis\Model\HTTP\Session;
ini_set('session.save_path', 'C:\tmp');
$session = Session::getInstance();
