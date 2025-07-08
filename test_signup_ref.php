<?php
// test_signup_ref.php
// ใช้สำหรับทดสอบ logic การหา ref_checked และ alliance

require_once '.framework/import.php';

$code = Aww::API_CODE['winx']; // กำหนด code สำหรับทดสอบ

// ตัวอย่าง input ที่ต้องการทดสอบ


// Priority: m > ref_m > cookie > default

// Priority: ref_m > m > ref_marketing > cookie > default
if (!empty($_GET['m'])) {
  $ref_m = $_GET['m'];
} else if (!empty($_POST['m'])) {
  $ref_m = $_POST['m'];
} else if (!empty($_COOKIE['m'])) {
  $ref_m = $_COOKIE['m'];
} else {
  $ref_m = '';
}


// ตรวจสอบว่า $ref_m มีในระบบหรือไม่
$getAlliasRefID = nga_management::getAllianceByID($code, $ref_m);
if (!empty($ref_m) && isset($getAlliasRefID['ref_link'])) {
  // ถ้า m มีค่าและหาเจอในระบบ ให้ใช้ m เป็น ref_marketing
  $ref_marketing = $ref_m;
} else {
  // ถ้า m ไม่มีในระบบ หรือไม่มีค่า ให้วนหา ref_m (GET/POST/COOKIE) หรือ default
  $ref_marketing = '';
  if (!empty($_GET['ref_m'])) {
    $ref_marketing = $_GET['ref_m'];
  } else {
    $ref_marketing = 'z0e380297';
  }
}

$getAlliasRef = nga_management::getAllianceByRefLink($code, $ref_marketing);


if (!empty($ref_m) && isset($getAlliasRefID['ref_link'])) {
  $ref_checked = $getAlliasRefID['ref_link'];
} elseif (isset($getAlliasRef['ref_link'])) {
  $ref_checked = $getAlliasRef['ref_link'];
} else {
  $ref_checked = '';
}


// แสดงผลลัพธ์แบบตาราง
function printTableRow($label, $value)
{
  printf("| %-18s | %-60s |\n", $label, $value);
}

echo str_repeat("=", 85) . "\n";
echo "| FIELD             | VALUE                                                       |\n";
echo str_repeat("-", 85) . "\n";
echo '<pre>';
print_r(['ref_m' => $ref_m]);
echo '</pre>';
echo '<pre>';
print_r(['ref_marketing' => $ref_marketing]);
echo '</pre>';
echo '<pre>';
print_r('get From m');
echo '</pre>';
// echo '<pre>'; print_r(json_encode($getAlliasRefID, JSON_UNESCAPED_UNICODE)); echo '</pre>';
echo '<pre>';
print_r($getAlliasRefID);
echo '</pre>';
echo '<pre>';
print_r('get from ref_m');
echo '</pre>';
// echo '<pre>'; print_r(json_encode($getAlliasRef, JSON_UNESCAPED_UNICODE)); echo '</pre>';
echo '<pre>';
print_r($getAlliasRef);
echo '</pre>';
echo '<pre>';
print_r('ref_checked');
echo '</pre>';
echo '<pre>';
print_r($ref_checked);
echo '</pre>';
echo str_repeat("=", 85) . "\n";

if (empty($ref_checked)) {
  echo '<pre>';
  print_r("[ERROR] ไม่พบข้อมูลพันธมิตร (Alliance) หรือ ref ผิดพลาด\n");
  echo '</pre>';
} else {
  echo '<pre>';
  print_r("[OK] พบ ref_link: $ref_checked\n");
  echo '</pre>';
}
