<?php
ob_start();
session_start();
$pagetitle = 'Show Items';
include 'files/ini.php';

$itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['exus'])) {
        $userid = $_SESSION['userid'];
        $itemid =  $_POST['itemid'];
        
        $details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS);

        
        if (!empty($details)) {
            $data = array(
                "notif_item" => $itemid,
                "notif_status" => '1',
                "notif_orderby" => $userid,
                "notif_detials" => $details
            );

            $countt = insertData("orderr", $data);

            if ($countt > 0) {
                echo "<script>
                        Swal.fire({
                            title: 'تم أرسال الطلب بنجاح. يرجى انتظار الرد',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1950,
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'حدثت مشكلة أثناء إرسال الطلب. يرجى المحاولة مرة أخرى',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1950,
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'يرجى إدخال تفاصيل الطلب',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1950,
                    });
                  </script>";
        }
    }
}

$stmt = $con->prepare("SELECT
                           items.* ,
                           categories.categories_name AS Category ,
                            users.user_name

                           FROM items

                           INNER JOIN
                             categories
                           ON
                             categories.categories_id  = items.items_cat 

                           INNER JOIN
                               users
                           ON
                           users.user_id  = items.items_owner 

                    WHERE
                    items_id = ? ");

// Execute query
$stmt->execute(array($itemid));
$count = $stmt->rowCount();

if ($count > 0) {
    $item = $stmt->fetch();
?>

  <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>

<h1 class="text-center">تفاصيل </h1>
<div class="container">
   <div class="row itemscard">

   
        <div class="col-md-5 text-center">
            <div class="vertical-center">
                <img class="img-responsive img img-thumbnail center-block" src="upload/items/<?php echo $item['items_image'];?>" alt='No Image'>
            </div>
            </div>
         <div class="col-md-7 item-info">
           <h2 class="colorr" style="  font-size: 2.8rem; "><?php   echo $item['items_name']; ?></h2>
           <h2 class="colorr"><?php    echo $item['items_desc']; ?></h2>
           <ul class="list-unstyled">
               <li  class="colorr">
                 <i class="fa fa-tags fa-fw"></i>
               التصنيف :  <?php  echo $item['Category']; ?> 
               </li>
               
               <li  class="colorr">
                 <i class="fa fa-user fa-fw"></i>
              المالك :   <?php  echo $item['user_name']; ?> 
               </li>
         </ul>
         <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="sign-up-form signup" style="    text-align: center;">
                    <input type="hidden" name="itemid" value="<?php echo $item['items_id']; ?>">
 
         <label for="" style="  font-size: 1.5rem;  color:#fff;  margin: 30px;"> يجب عليك ادخال تفاصيل الطلب</label><br>

          <div class="form-group mt-2">
						 						<input type="text" name="details" class="inputdet" required placeholder="الوصـف" id="logpass" autocomplete="off">
												<i class="input-icon uil-align-alt"></i>
		 </div>
          <input type="submit" name="exus" class='btndet ' style="border:none; margin-bottom:45px;" value="اطلبها الان" />

        </form>
       <?php }?>

         </div>

   </div>




   <!--  start add item to  cart -->

     <?php if (isset($_SESSION['user'])) { ?>



    

       <?php } ?>    
    
</div>



  
  