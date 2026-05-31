<?php

require '../config/database.php';
require '../app/controllers/barangcontroller.php';

$controller = new barangcontroller($conn);
$controller->hapus($_GET['id']);

?>