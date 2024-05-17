<?php



session_start();

include 'files/ini.php';

if (isset($_SESSION['user']) ) {

    $userid= $_SESSION['userid'];

    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';


     if ($do == 'manage'){

               $stmt = $con->prepare("SELECT
               n.notif_id,
               n.notif_item,
               n.notif_status,
               n.notif_orderby,
               n.notif_detials,
               n.notif_date,
               u_owner.user_name AS owner_name,
               u_owner.user_phone AS owner_phone,
               u_orderby.user_name AS order_by_name,
               u_orderby.user_phone AS order_by_phone
           
           FROM
           
               orderr n
           JOIN items i ON n.notif_item = i.items_id
           JOIN users u_owner ON i.items_owner = u_owner.user_id
           JOIN users u_orderby ON n.notif_orderby = u_orderby.user_id
           WHERE
               u_owner.user_id = ? ");


               $stmt->execute(array($userid));

               $items = $stmt->fetchall();

               if (! empty($items)) {


                $stmt = $con->prepare("SELECT
                n.notif_id,
                n.notif_item,
                n.notif_status,
                n.notif_orderby,
                n.notif_detials,
                n.notif_date,
                u_owner.user_name AS owner_name,
                u_owner.user_phone AS owner_phone,
                u_orderby.user_name AS order_by_name,
                u_orderby.user_phone AS order_by_phone
            
            FROM
            
                orderr n
            JOIN items i ON n.notif_item = i.items_id
            JOIN users u_owner ON i.items_owner = u_owner.user_id
            JOIN users u_orderby ON n.notif_orderby = u_orderby.user_id
            WHERE
                u_owner.user_id = ? AND n.notif_status =1 ");
 
 
                $stmt->execute(array($userid));

        
                $items0 = $stmt->fetchall();
  

         ?>

       <section class="banner_partex">

           <div class="landing" style="padding-top:0; margin-top:-95;" id="team">

             <!-- Start Team -->

             <div class="team" id="team" style="padding-top:0;">
               <section class="about_us">
                

               <div class="container" style="display:block;">
               <h1 class="notifih1">الأشعارات المنتظرة </h1>

               <?php
                    if (! empty($items0)) {} else  {
                    ?>
                    <h3 style="font-size:37px; text-align: center; margin: 10px;">
                       لا يوجد لديك اي اشعارات جديدة
                     </h3>

                    <?php
                  }}
                 ?> 

               </div>
             </section>
             </div>


             <div class="container"  data-aos="zoom-out" style="  display: block;">

             <h1 class="notifih1">كل الأشعارات  </h1>

               <div class="table-responsive">
                     <table style="background-color: #f1f9ff;" class="main-table text-center table table-borderd">
                           <tr style="background-color: #00504e; color:#fff; font-weight:bolder;">
                               <td>#ID</td>
                               <td> اسم العينية</td>
                               <td>تم طلبها من</td>
                               <td>رقم تواصله</td>
                               <td> تفاصيل</td>
                               <td>التاريخ</td>
                               <td>الوقت</td>
                               <td>الموافقات</td>

                           </tr>

                           <?php

                               foreach ($items as $item) {
                                 $datetime = strtotime($item['notif_date']);
                                 $newtime = date( 'H:i:s', $datetime );
                                 $newdate = date( 'Y/D/M', $datetime );

                                     echo "<tr class='cc'  >";
                                           echo "<td>" . $item['notif_id'] . "</td>" ;
                                           echo "<td>" . $item['notif_item'] . "</td>" ;
                                           echo "<td>" . $item['order_by_name'] . "</td>" ;
                                           echo "<td>" . $item['order_by_phone'] . "</td>" ;
                                           echo "<td>" . $item['notif_detials'] . "</td>" ;
                                           echo "<td>" .  $newdate ."</td>" ;
                                           echo "<td>" . $newtime  ."</td>" ;
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


         <?php   } 


        

   elseif ($do =='Delete') {

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
}
?>
