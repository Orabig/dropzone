<?php

session_start();

header('Access-Control-Allow-Origin: *');

$ds          = DIRECTORY_SEPARATOR;
$storeFolder = '/var/www/uploads';

$LIMIT = 10 * 1024 * 1024; #  10 Mo max

if (!empty($_FILES)) {
  if ($_FILES['file']['size'] > $LIMIT) {
    // file is too big
    header('HTTP/1.1 402', true, 402);
    return 'File is too big.';
  } else {
    $topic_id = $_GET['topic_id'];
    $username = $_GET['username'];
    $hashing = md5($topic_id. $file_name. rand()) . '_';

    $whiteSpace = ' ';
    $pattern    = '/[^a-zA-Z0-9.'  . $whiteSpace . ']/u';
    $file_name  = $hashing . preg_replace($pattern, '', (string)$_FILES['file']['name']);

    $tempFile   = $_FILES['file']['tmp_name'];
    $targetPath = $storeFolder . $ds;
    $targetFile = $targetPath . $file_name;
    move_uploaded_file($tempFile, $targetFile);

    echo json_encode(array(
      'name'  => $file_name,
      'hash'  => $hashing
    ));
	return "CACA";
  }
} else {
  return 'File is empty.';
}

?>
