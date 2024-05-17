<?php


  ini_set('display_errors' , 'On');
  error_reporting(E_ALL);

  include 'files/connect.php';

  $sessionUser = '';
  if (isset($_SESSION['username'])) {
    $sessionUser = $_SESSION['username'];

  }


  include 'files/header.php';
