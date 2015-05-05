<?php

session_start();

header('Access-Control-Allow-Origin: *');

$ds          = DIRECTORY_SEPARATOR; //1
$storeFolder = 'uploads';           //2

if (!empty($_FILES)) {
  if ($_FILES['file']['size'] > 25000000) {
    // file is too big
    header('HTTP/1.1 402', true, 402);
    return 'File is too big.';
  } else {
    $topic_id = $_GET['topic_id'];
    $username = $_GET['username'];
    if ($_GET['hashing'] == 'ok's) {
      $hashing = md5($topic_id. $file_name) . '_';
    } else {
      $hashing = '';
    }

    $whiteSpace = ' ';
    $pattern    = '/[^a-zA-Z0-9.'  . $whiteSpace . ']/u';
    $file_name  = $hashing . preg_replace($pattern, '', (string)$_FILES['file']['name']);

    $tempFile   = $_FILES['file']['tmp_name'];                      //3
    $targetPath = dirname( __FILE__ ) . $ds . $storeFolder . $ds;   //4
    $targetFile = $targetPath . $file_name;                         //5
    move_uploaded_file($tempFile, $targetFile);                     //6

    echo json_encode(array(
      'name'  => $file_name,
      'url'   => 'https://qiscus.s3.amazonaws.com/' . $file_name
    ));
  }
} else {
  return 'File is empty.';
}

?>