<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>أخذ و عطاء</title>

    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
         <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
         <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
         <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
         <link rel="stylesheet" href="<?php echo $css; ?>ack.css">

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap.rtl.css" />

    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="style.css" />
    <!-- Font Awesome -->

        <link rel="stylesheet" href="css/all.css" />
        
    <!-- Google Fonts -->
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet" />
  </head>
  <body>
    <!-- Start Header -->
    <div class="header fixed-top" id="header">
      <div class="container">
        <a href="#" class="logo">إدمن أخذ و عطاء </a>
        <ul class="main-nav">


          <li>
            <a ctyle="font-weight:bold;"  style="font-weight:bold;" href="items.php" >
              <i class="fa-solid fa-hand"></i>
                   الأصناف
            </a>
          </li>
          <li>
              <a class="" style="font-weight:bold;" href="members.php" >
                <i class="fa-solid  fa-arrow-right-to-bracket"></i>المستخدمين</a>
          </li>
          <li>
              <a class="" style="font-weight:bold;" href="#" >
                <i class="fa-solid fa-notifications"></i>  الطلبات</a>
          </li>

          <?php  if (isset($_SESSION['userses'])) {?>
            <li>
              <a class="" style="font-weight:bold;" href="logout.php" >
                <i class="fa-solid fa-arrow-right-from-bracket"></i> تسجيل خروج</a>
          </li><?php  }?>



        </ul>
        </ul>
      </div>
    </div>

    <!--  <script type="text/javascript">
	$(document).ready(function(){
		var url = "modalbox.php";
		jQuery('#modellink').click(function(e) {
		    $('.modal-container').load(url,function(result){
				$('#myModal').modal({show:true});
			});
		});
	});
</script>
   End Header -->
