<?php



session_start();

include 'files/ini.php';

if (isset($_SESSION['user']) ) {

    $userid= $_SESSION['userid'];
    $type = $_SESSION['type'];  

    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';


     if ($do == 'manage'){

      if($type ==2 ){

               $stmt = $con->prepare("SELECT
               n.notif_id,
               n.notif_item,
               n.item_owner,
               n.notif_status,
               n.notif_orderby,
               n.notif_detials,
               n.notif_date,

               i.items_name,
               i.items_image,
               u_owner.user_name AS owner_name,
               u_owner.user_phone AS owner_phone

           FROM
           
               orderr n
           JOIN items i ON n.notif_item = i.items_id
           JOIN users u_owner ON i.items_owner = u_owner.user_id
           WHERE
               n.notif_orderby = ? ");


               $stmt->execute(array($userid));

               $items = $stmt->fetchall();

               if (! empty($items)) {
         ?>
       <section class="banner_partex">
           <div class="landing" style="padding-top:0; margin-top:50;" id="team">

             <!-- Start Team -->



             <div class="container"  data-aos="zoom-out" style="  display: block;">

             <h1 class="notifih1">كل الطلبات  </h1>
               <div class="table-responsive">
                     <table style="background-color: #f1f9ff;" class="main-table text-center table table-borderd">
                           <tr style="background-color: #00504e; color:#fff; font-weight:bolder;">
                               <td>#ID</td>
                               <td> اسم العينية</td>
                               <td> المعطي</td>
                               <td>الجوال</td>
                               <td> تفاصيل</td>
                               <td>التاريخ</td>
                               <td>الحالة</td>
                           </tr>
                           <?php

                               foreach ($items as $item) {
                                 $datetime = strtotime($item['notif_date']);
                                 $newtime = date( 'H:i:s', $datetime );
                                 $newdate = date( 'Y/D/M', $datetime );

                                     echo "<tr class='cc'  >";
                                           echo "<td>" . $item['notif_id'] . "</td>" ;
                                           echo "<td>" . $item['items_name'] . "</td>" ;
                                           echo "<td>" . $item['owner_name'] . "</td>" ;
                                           echo "<td>" . $item['owner_phone'] . "</td>" ;
                                           echo "<td>" . $item['notif_detials'] . "</td>" ;
                                           echo "<td>" .  $newdate ."</td>" ;
                                         echo "<td>";
                                             if ($item['notif_status'] == 1) {
                                               echo "في انتظار الرد";
                                             } elseif ($item['notif_status'] == 2) {
                                               echo  "<span style=' background:#5995fd; color:#fff; padding:4px; '>
                                                مقبول
                                                </span>
                                               ";
                                              }
                                              elseif ($item['notif_status'] == 3) {
                                               echo  "<span style='background:#ff4f5f; color:#fff; padding:4px; '>
                                                مرفوض
                                                </span>
                                               ";
                                              }
                                     echo  "</td>";
                                     echo "</tr>";
                               }

                            ?>

                     </table>
               </div>

             </div>
           </div>


</section>
         <?php }else{?>
          <div class="team" id="team" style="padding-top:200;margin-bottom:500px;">
               <section class="about_us">
                <div><h1 style="margin-bottom:150px;    text-align: center;     font-size: 4em;">الطلبات  </h1></div>
                     <h3 style="font-size:37px; text-align: center; margin: 10px;">
                        لا يوجد  لديك اي طلبات
                      </h3>
               </div>
             </section>
             </div>
<?php
         }  
        
     }








// the another user .........................................................................................................
     if($type ==1 ){

      $stmt = $con->prepare("SELECT
      n.notif_id,
      n.notif_item,
      n.item_owner,
      n.notif_status,
      n.notif_orderby,
      n.notif_detials,
      n.notif_date,
      i.items_name,
      i.items_image,

      u_owner.user_name AS owner_name,
      u_owner.user_phone AS owner_phone,

      u_orderby.user_name AS orderby_name,
      u_orderby.user_phone AS orderby_phone
  FROM
  
      orderr n
  JOIN items i ON n.notif_item = i.items_id
  JOIN users u_owner ON i.items_owner = u_owner.user_id
  JOIN users u_orderby ON n.notif_orderby = u_orderby.user_id

  WHERE
      n.item_owner = ? ");


      $stmt->execute(array($userid));

      $items = $stmt->fetchall();

      if (! empty($items)) {
?>
<section class="banner_partex">
  <div class="landing" style="padding-top:0; margin-top:50;" id="team">

    <!-- Start Team -->



    <div class="container"  data-aos="zoom-out" style="  display: block;">

    <h1 class="notifih1">كل الطلبات </h1>
      <div class="table-responsive">
            <table style="background-color: #f1f9ff;" class="main-table text-center table table-borderd">
                  <tr style="background-color: #00504e; color:#fff; font-weight:bolder;">
                      <td>#ID</td>
                      <td> اسم العينية</td>
                      <td> الأخذ</td>
                      <td>الجوال</td>
                      <td> تفاصيل</td>
                      <td>التاريخ</td>
                      <td>الحالة</td>
                  </tr>
                  <?php

                      foreach ($items as $item) {
                        $datetime = strtotime($item['notif_date']);
                        $newtime = date( 'H:i:s', $datetime );
                        $newdate = date( 'Y/D/M', $datetime );

                            echo "<tr class='cc'  >";
                                  echo "<td>" . $item['notif_id'] . "</td>" ;
                                  echo "<td>" . $item['items_name'] . "</td>" ;
                                  echo "<td>" . $item['orderby_name'] . "</td>" ;
                                  echo "<td>" . $item['orderby_phone'] . "</td>" ;
                                  echo "<td>" . $item['notif_detials'] . "</td>" ;
                                  echo "<td>" .  $newdate ."</td>" ;

                                  echo "<td>";
                                  if ($item['notif_status'] == 1) {
                                    echo "<a
                                    href='orderr.php?do=Approve&itemid=" . $item['notif_id'] . "'
                                    class='btn btn-info activate'>
                                    <i class='fa-solid fa-check' style='margin-left:5px;' ></i> موافق</a>";
                           ?>   <a class='btn' style='background:#ff4f5f;' href="orderr.php?do=Delete&itemid=<?php echo $item['notif_id']; ?>" ><i class='fa-solid fa-x' style='margin-left:4px;'></i> رفــض</a><?php

                                  } elseif ($item['notif_status'] == 2) {
                                    echo  "<span style=' background:#5995fd; color:#fff; padding:4px; '>
                                     مقبول
                                     </span>
                                    ";
                                   }
                                   elseif ($item['notif_status'] == 3) {
                                    echo  "<span style='background:#ff4f5f; color:#fff; padding:4px; '>
                                     مرفوض
                                     </span>
                                    ";
                                   }
                          echo  "</td>";
                            echo "</tr>";
                      }

                   ?>

            </table>
      </div>

    </div>
  </div>


</section>
<?php }else{?>
 <div class="team" id="team" style="padding-top:200;margin-bottom:500px;">
      <section class="about_us">
       <div><h1 style="margin-bottom:150px;    text-align: center;     font-size: 4em;">الطلبات  </h1></div>
            <h3 style="font-size:37px; text-align: center; margin: 10px;">
               لا يوجد  لديك اي طلبات
             </h3>
      </div>
    </section>
    </div>
<?php
}  

}

    
    } elseif ($do =='Delete') {

               $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ?  intval($_GET['itemid']) : 0;

                    $stmt = $con->prepare("SELECT
                                                   notif_id 
                                            FROM
                                                     orderr
                                            WHERE
                                               notif_id  = :znotif_id 
                                     ");
                                                   $stmt->execute(array(

                                                         'znotif_id' => $itemid));


                     $count = $stmt->rowCount();


                   if ($count> 0) {

                          $stmt = $con->prepare("UPDATE orderr SET notif_status = 3 WHERE notif_id = ?");

                          $stmt->execute(array($itemid));

                        ?> <script type="text/javascript">
                        Swal.fire({
                        icon: 'error',
                            title: 'تم رفض الطلب',
                            showConfirmButton: false,
                            timer: 1950,
                        })
                        </script><?php

                header("refresh:1.8;url=orderr.php");
                        exit();



                   }  else {

                     echo "<script type='text/javascript'>
                       alert(' رقم الأشعار غير موجود');
                     </script>";

                    header('Location: orderr.php');

                  exit();

                     }


   } elseif ($do == 'Approve') {

                    $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ?  intval($_GET['itemid']) : 0;

                    $stmt = $con->prepare("SELECT
                                                * 
                                            FROM
                                                    orderr
                                            WHERE
                                            notif_id  = :znotif_id 
                                    ");
                                                $stmt->execute(array(

                                                        'znotif_id' => $itemid));

                    $count = $stmt->rowCount();

                if ($count> 0) {

                    $stmt = $con->prepare("UPDATE orderr SET notif_status = 2 WHERE notif_id = ?");

                       $stmt->execute(array($itemid));


                       echo "<script type='text/javascript'>
                         alert(' تم الموافقة على الأشعار وارسالة');
                       </script>";


                      header('Location: orderr.php');

                    exit();



                }  else {

                  echo "<script type='text/javascript'>
                    alert(' رقم الأشعار غير موجود');
                  </script>";

                 header('Location: excuse.php');

               exit();

                  }


} else {

  header('Location: index.php');

  exit();
}


include 'files/footer.php';
ob_end_flush();
}{
  header('Location: login.php');

  exit();

}
?>
