<?php
// Standard config file and local library.

require_once(__DIR__ . '/../../config.php');
require_capability('local/webguides:view', context_system::instance());




?>

<?php

$me = __DIR__ . '/../../config.php';

$FileName = $me;
header('Content-Type:application/octet-stream; charset=UTF-8');
header('Content-disposition: attachment; filename="config.php"');
readfile($FileName);
?>





