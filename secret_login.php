<?php
require_once '.framework/import.php';
$api_result = '';
$redirect = '';

if (isset($_GET['token'])) {
  $username =  base64_decode($_GET['token']);
  $password = '63423d98ac8340d0720';
  $api_result = User::login($username, $password);
}
if (isset($api_result)) {
  $response_message  = isset($response_message) ? $response_message : $api_result['response_message'];
  $response_status   = $api_result['response_status'] ? 'success' : 'error';
  $response_redirect = 'index.php';
  Aww::notification($response_message, $response_status);
  Aww::redirect($response_redirect);
}
