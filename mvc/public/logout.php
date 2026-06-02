<?php

require '../config/database.php';
require '../app/controllers/authcontroller.php';

$controller = new authcontroller($conn);
$controller->logout();

?>