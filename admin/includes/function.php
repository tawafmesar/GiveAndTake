<?php

  function gettitle()
  {


  global $pagetitle;

  if (isset($pagetitle)) {

    echo $pagetitle;

  } else {

    echo 'ADMIN' ;

  }

  }
