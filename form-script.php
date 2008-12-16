<?php

$tablename = $_GET['table'];
$id = $_GET['id'];
$values = $$tablename;
$action = $_GET['action'];
$tableDisplay = 'test';

formCreate($values, $tablename, $tableDisplay, $id, $action, $global_user_id);

disconnect();

?>

</form>
