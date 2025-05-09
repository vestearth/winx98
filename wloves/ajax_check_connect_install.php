<?php
if (file_exists('../system/installation.php')) {
  require_once '../system/installation.php';

  if (isset($_POST['db_server'])) {
    $result = test_db_connection($_POST['db_server'], $_POST['db_name'], $_POST['db_username'], $_POST['db_password'], $_POST['db_port']);
    if ($result) {
      echo 'success';
    } else {
      echo 'fail';
    }
  }
} else {
  echo 'No file';
}
?>