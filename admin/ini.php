<?php

ini_set('display_errors' , 'On');
error_reporting(E_ALL);
  include 'connect.php';
    // Rotes

    $tpl  = 'includes/templates/';  // templates Directory
    $lang = 'includes/languages/';  // languages Directory
    $func = 'includes/functions/';  // function Directory
    $css  = 'layout/css/';          // css Directory
    $js   = 'layout/js/';           // js Directory


 // include the Important file

  include $func . '/func.php';
  include $lang . 'en.php';
  include $tpl . 'navbar.php'; 
