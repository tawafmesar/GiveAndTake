<?php

  /*  $lang = array(
     'tj' => 'Tawaf Jehad' );
      echo $lang['tj'] ; */

  function lang( $phrase ) {

    static $lang = array(

      // Dashbourd page

      // Navbar Link

      'HOME_ADMIN'    => 'HOME',
      'CATEGOR'     => 'Categories',
      'ITEMS'         => 'Items',
      'MEMBERS'       => 'Members',
      'COMMENTS'    => 'Comments',
      'STATISTICS'    => 'Statistics',
      'LOGS'          => 'Logs'


    );

    return $lang[$phrase];

  }
