<?php

/*

============================================================
=== manage members page
=== you can add | edit | delete members from here
============================================================
*/

session_start();

$pagetitle = 'Items';

if (isset($_SESSION['userses'])) {

  include 'ini.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

  // START MANAGE page

  if ($do == 'manage') { // start manage members page

    $query = "";

    if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

      $query = "AND RagStatus = 0";

    }

    // select all users exept Admin

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
");

    // execute the statement

    $stmt->execute();

    // assign to variable

    $rows = $stmt->fetchall();

    if (!empty($rows)) {


      ?>

      <style>


      </style>

      <div style="text-align: center;">
        <h1 class="text-center" style="text-align: center;">إدارة الطلبات</h1>
        
        <!-- <form action="members.php?do=search" method="POST" class="search-form">
          <input type="text" name="query" placeholder=" أبحث في المستخدمين" class="search-input">
          <button type="submit" class='btn btn-info activate'>بحث</button>
        </form> -->

      </div>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-borderd">
            <tr>
              <td>#ID</td>
              <td>اسم العينية</td>
              <td>المعطي</td>
              <td>جوال المعطي</td>
              <td>الأخذ</td>
              <td>رقم الأخذ</td>
              <td>تفاصيل الطلب</td>
              <td>التاريخ</td>
              <td>الحالة</td>

              <td>Control</td>
            </tr>

            <?php

            foreach ($rows as $row) {
              echo "<tr>";
              echo "<td>" . $row['notif_id'] . "</td>";
              echo "<td>" . $row['items_name'] . "</td>";
              echo "<td>" . $row['owner_name'] . "</td>";
              echo "<td>" . $row['owner_phone'] . "</td>";
              echo "<td>" . $row['orderby_name'] . "</td>";
              echo "<td>" . $row['orderby_phone'] . "</td>";
              echo "<td>" . $row['notif_detials'] . "</td>";

              echo "<td>" . $row['notif_date'] . "</td>";

              echo "<td>";

              if ($row['notif_status'] == 1) {
                echo " في انتظار الرد";

              }
              if ($row['notif_status'] == 2) {
                echo "تم الموافقة";

              }
              if ($row['notif_status'] == 3) {
                echo "لم يتم الموافقة";

              }

              echo "</td>";

              echo "<td>
                     <a href='orderr.php?do=Delete&userid=" . $row['notif_id'] . "' class='btn btn-danger confirm'><i class='fa fa-trash-o' ></i>حذف </a>";



              echo "</td>";
              echo "</tr>";
            }

            ?>

          </table>
        </div>


        <!-- <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"> New member</i></a> -->

      </div>

    <?php } else {

      echo '              <h1 style="text-align: center;">لايوجد اي نتائج لعرضها</h1>      ';

    }

    ?>


  <?php    // end manage members page
    // start members page
  } elseif ($do == 'search') { // add members page  

    // insert member page


    // check if user come from forms or any page

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      echo '<h1 class="text-center">نتائج البحث في المستخدمين</h1>';
      echo "<div class='container' style='text-align: center;'>";
      echo "<a href='members.php'  class='btn btn-info activate'>عوده</a> <br>";



      // Get variables from the page
      $query = $_POST['query'];
      if (!empty($_POST["query"])) {
        // Connect to the database
        $con = new PDO("mysql:host=localhost;dbname=giveandtake", "root", "");
        
        // Prepare the SQL statement
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name LIKE :query OR user_phone LIKE :query OR user_email LIKE :query");
        
        // Bind the query parameter
        $stmt->bindValue(':query', '%' . $_POST["query"] . '%');
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch all results
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Check if we have results
        if ($rows) {?>
      <div class="table-responsive">
          <table class="main-table text-center table table-borderd">
            <tr>
              <td>#ID</td>
              <td>الأسم</td>
              <td>الجوال</td>
              <td>الأيميل</td>
              <td>الأنشاء</td>
              <td>النوع</td>

              <td>Control</td>
            </tr>

            <?php

            foreach ($rows as $row) {
              echo "<tr>";
              echo "<td>" . $row['user_id'] . "</td>";
              echo "<td>" . $row['user_name'] . "</td>";
              echo "<td>" . $row['user_phone'] . "</td>";
              echo "<td>" . $row['user_email'] . "</td>";
              echo "<td>" . $row['user_create'] . "</td>";
              echo "<td>";

              if ($row['user_type'] == 1) {
                echo "معطي";
              } else {
                echo "محتاج";

              }

              echo "</td>";
              echo "<td>
                                                  <a href='members.php?do=Delete&userid=" . $row['user_id'] . "' class='btn btn-danger confirm'><i class='fa fa-trash-o' ></i>Delete</a>";

              if ($row['user_approve'] == 0) {

                echo "<a href='members.php?do=Activate&userid=" . $row['user_id'] . "' class='btn btn-info activate'><i class='fa fa-check-square-o' ></i> Activate</a>";

              }

              echo "</td>";
              echo "</tr>";
            }

            ?>

          </table>
        </div>


            <?php

        } else {
            echo "<h1> لايوجد اي نتائج</h1>";
        }
    } else {
        echo "Please enter a search query.";
    }






    } else {

      echo "<div class='container'>";


      $error = " <div class='alert alert-danger'>sorry you cant browse this page dirctory </div>";

      redirectHome($error, 3);

      echo "</div>";

    }

    echo "</a>";




  }  // end update page
  elseif ($do == 'Delete') { //  start delelt member page

    echo '<h1 class="text-center"> حذف طلب</h1>';
    echo "<div class='container'>";


    // Check if get request userid is numeric and get the integer value of it

    /*  if (isset($_GET['userid']) && is_numeric($_ ['userid'])){
        echo intval($_ ['userid']);
      }else { echo 0; }  */
    $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

    // check user if not exesit




      $stmt = $con->prepare("DELETE FROM orderr WHERE notif_id   = :zuser");

      $stmt->bindParam(":zuser", $userid);

      $stmt->execute();
      // WE CAN USE THIS QUERY BUT CHING :ZUSER ? $stmt->execute(array($userid));

      echo '<div class="alert alert-success">' . ' تم حذف  : '. $stmt->rowCount()  . '</div>';

      header("refresh:1.5;url=orderr.php");

      echo '</div>';




    echo '</div>';

  }

  // end delete page

  include $tpl . 'footer.php';

} else {

  header('Location: index.php');

  exit();
}
