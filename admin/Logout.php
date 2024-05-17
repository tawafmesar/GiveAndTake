<?php

    session_start();     // start the session

    session_unset();     // unset the data

    session_destroy();   // Destroy the session

    header('location: index.php');

    exit();


    
