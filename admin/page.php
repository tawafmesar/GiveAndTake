<?php


  /*

       Categories => [ Manage | Edite | Update | Add | Insert | dELET | Stat ]

      by action out do

      or
      by if

      $do = '';

      if (isset($_GET['do'])) {

        $do = $_GET['do'];

      } else {

        echo $do = 'manage';
      }
      condition ? true : false

        $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';


    */


    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';
    // IF (     condition  ){    CODE    }ELSE{ CODE  };      

    // if the page is main page

    if ($do == 'manage') {

      echo 'welcome you are in manage category page ';
      echo '<a href="page.php?do=add">Add new category +</a>';
          //or href="?do=add"

    } elseif ($do == 'add') {

      echo 'welcome you are in add category page';

    } elseif ($do == 'insert') {

      echo 'welcome you are in add category page';

    } else {

      echo "Error  there\'s no page with this name ";      }
