<?php
include 'system/required/import.php';
$id   = $_GET['id'];
$data = Amst::getByID('uwklw_tmp_login_text', 'url_text', $id);
echo ($data);
