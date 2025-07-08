<?php
// test_signup_ref.php
// ใช้สำหรับทดสอบ logic การหา ref_checked และ alliance

require_once '.framework/import.php';

$code = Aww::API_CODE['winx']; // กำหนด code สำหรับทดสอบ

// ตัวอย่าง input ที่ต้องการทดสอบ


// Priority: URL parameter > cookie > default (m=1)

// Priority: URL parameter > cookie > default
$ref_from_url = '';
$ref_type = '';

// 1. เช็ค URL parameter ก่อน
if (!empty($_GET['m'])) {
  $ref_from_url = $_GET['m'];
  $ref_type = 'm';
} elseif (!empty($_GET['ref_m'])) {
  $ref_from_url = $_GET['ref_m'];
  $ref_type = 'ref_m';
}

// 2. ถ้ามี URL parameter ให้เซฟใน cookie
if (!empty($ref_from_url)) {
  setcookie('ref_value', $ref_from_url, time() + (86400 * 30), "/");
  setcookie('ref_type', $ref_type, time() + (86400 * 30), "/");
  $ref_m = ($ref_type == 'm') ? $ref_from_url : '';
  $ref_marketing = $ref_from_url;
} else {
  // 3. ถ้าไม่มีใน URL ให้เช็ค cookie
  if (!empty($_COOKIE['ref_value']) && !empty($_COOKIE['ref_type'])) {
    $ref_from_cookie = $_COOKIE['ref_value'];
    $cookie_type = $_COOKIE['ref_type'];
    $ref_m = ($cookie_type == 'm') ? $ref_from_cookie : '';
    $ref_marketing = $ref_from_cookie;
  } else {
    // 4. ถ้าไม่มีใน cookie ให้ใช้ m=1 เป็น default
    $ref_m = '1';
    $ref_marketing = '1';
    setcookie('ref_value', '1', time() + (86400 * 30), "/");
    setcookie('ref_type', 'm', time() + (86400 * 30), "/");
  }
}

// ตรวจสอบว่า $ref_m มีในระบบหรือไม่
$getAlliasRefID = nga_management::getAllianceByID($code, $ref_m);
if (!empty($ref_m) && isset($getAlliasRefID['ref_link'])) {
  // ถ้า m มีค่าและหาเจอในระบบ ให้ใช้ m เป็น ref_marketing
  $ref_marketing = $ref_m;
} else {
  // ถ้า m ไม่มีในระบบ ให้ใช้ ref_marketing จาก cookie หรือ default
  if (empty($ref_marketing)) {
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
print_r(['ref_from_url' => $ref_from_url]);
echo '</pre>';
echo '<pre>';
print_r(['ref_type' => $ref_type]);
echo '</pre>';
echo '<pre>';
print_r(['cookie_ref_value' => $_COOKIE['ref_value'] ?? 'Not set']);
echo '</pre>';
echo '<pre>';
print_r(['cookie_ref_type' => $_COOKIE['ref_type'] ?? 'Not set']);
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
