<?php

$legal_require_php= 333666999;
require ("detectuser.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title><?php
require_once('config.php');
echo $config['title'];
?>
</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
include('contenttables.php');
?>

</body>

</html>