<?php

header('Content-Type:text/html; charset=utf-8');

echo '<pre>';
print_r($_POST);
echo '</pre>';

$name = $_POST['name'];
$pw = $_POST['pw'];

echo "$name 과 $pw 를 잘 받았습니다.";

?>