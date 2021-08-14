<?php
session_start();
switch (true) {
  case (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] === true)):
  case (isset($_SERVER['HTTP_SCHEME']) && ($_SERVER['HTTP_SCHEME'] == 'https')):
  case (443 === $_SERVER['SERVER_PORT']):
    $scheme = 'https://';
    break;
  default:
    $scheme = 'http://';
    break;
};

header('Location: '. $scheme.str_replace("/index.php","",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']) .'/public');