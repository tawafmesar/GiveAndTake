<?php 
ob_start();
session_start();



include 'files/ini.php';



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['add'])) {






      $email = $_SESSION['useremail'];
      $name = $_POST['name'];
      $number = $_POST['number'];
      $details = $_POST['mess'];
            $myemail = "balaghikk@gmail.com";



           sendEmail($myemail,  "
           الاسم :  $name 
           البريد الالكتروني : $email
           رقم الجوال :  $number
           تفاصيل الرسالة : $details
              ", "رساله جديدة");


        }





        echo "  <h1 class='succes' id='hide'>
            تم إرسال رسالتك بنجاح
            </h1>";

  }

  ?>


      <div class="content w-full">
       
        <!-- Start add -->
        <div class="add" style="    direction: ltr;">
  <?php
    if ($countt > 0) {


      echo "  <h1 class='succes' id='hide'>
            تم إضافة البلاغ بنجاح
            </h1>";

      header("refresh:1;url=add.php");

    }
    ?>
        
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
<link rel='stylesheet' href='css/login.css'>


<!-- partial:index.partial.html -->
<div class="container" id="container">



    <div class="form-container sign-in-container">
            <form   action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <!-- <h1>إنشاء حساب</h1> -->
            
                    <input type="text" name="name" placeholder=" اسمك الكامل" required style="direction: rtl;" />
                    <input class="rtl" type="text" name="number" placeholder="رقم الجوال" required style="direction: rtl;"/>
                    <textarea name="mess" id="details" cols="30" rows="10" placeholder="رسالتك" style="direction: rtl;"></textarea>
                    <button name="add">إرسال</button>
                </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">

                <div class="overlay-panel overlay-right">

                    <img src="./img/logo.png" width="60%" alt="">

                    <h4>     للأستفسار يمكنكم ارسال رسالة    </h4>
                    <h4>وسيتم الرد عليكم في اقرب وقت ممكن</h4>
                </div>
            </div>
        </div>
                  </div>
        
                    <script>

                    const activee = document.getElementById('contact');
                          activee.classList.add("active");
           
                          document.addEventListener("DOMContentLoaded", function() {
            const h4Element = document.getElementById("hide");
            setTimeout(function() {
                h4Element.style.display = "none";
            }, 2500); // 2000 milliseconds (2 seconds)
            });

        </script>
        

                  <!-- partial -->
                  <script src="./js/login.js"></script>

        
                </div>
                 <!-- end add -->

              </div>
            </body>
          </html>

<?php

ob_end_flush();

?>


