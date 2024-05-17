<?php

ob_start(); // output buffering start

session_start();

if (isset($_SESSION['userses'])) {

    $pagetitle = 'Dashboard';

   include 'ini.php';

// START Dashboard page



      $numUser = 8; // number of user to disapley on pamil

      $latestUser = getlatest("*" , "users" ,"UserID" , $numUser );   //the latest user array

      $numItems = 8; // number of Items to disapley on pamil

      $latestItems = getlatest("*" , "items" ,"Item_ID" , $numItems);   //the latest Items array

      $numComment = 8;
?>
    <div class="container home-stats text-center">
         <h1>Dashboard</h1>
         <div class="row">
            <div class="col-md-3">
              <div class="stat st-members">
                <i class="fa fa-users"></i>
                  <div class="info">
                    <a href="members.php">
                          Total Members
                          <span> <?php echo countItems('UserID','users'); ?>
                          </span>
                    </a>
                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-pending">
                  <i class="fa fa-user-plus"></i>
                   <div class="info">
                     <a href="members.php?do=manage&page=Pending">
                          Pending Members
                          <span><?php echo checkItem('RagStatus','users', 0); ?></span>
                        </a>
                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-items">
                  <i class="fa fa-tag"></i>
                    <div class="info">
                      <a href="items.php?do=manage">
                        Total items
                            <span> <?php echo countItems('Item_ID','items'); ?>
                            </span>
                       </a>
                    </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-comments">
                  <i class="fa fa-comments"></i>
                  <div class="info">
                    <a href="comments.php">
                    Total comments
                    <span> <?php echo countItems('c_id','comments'); ?></span>
                  </a></div>
              </div>
            </div>

         </div>
    </div>

    <div class="container latest">
        <div class="row">
              <div class="col-sm-6">
                  <div class="panel panel-default">
                        <div class="panel-heading">
                              <i class="fa fa-users" ></i>
                              Latest <?php echo $numUser; ?> Registerd Users
                              <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                              </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                              <?php

                                if (! empty($latestUser)) {

                                  foreach ($latestUser as $user) {

                                          echo '<li>';
                                                  echo $user['Username'];

                                                      echo "<a href='members.php?do=Edit&userid=" . $user['UserID'] . "' class='btn btn-success pull-right '><i class='fa fa-edit' ></i> Edit</a>";
                                                      echo "<a href='members.php?do=Delete&userid=" . $user['UserID'] . "' class='btn btn-danger confirm pull-right '><i class='fa fa-trash-o' ></i> Delete</a>";
                                                      if ($user['RagStatus'] == 0) {
                                                         echo "<a  href='members.php?do=Activate&userid=" . $user['UserID'] . "' class='btn btn-info activate pull-right'><i class='fa fa-check-square-o' ></i> Activate</a>";
                                                      }
                                                  echo '</sapn>' ;
                                                  echo '</a>';
                                          echo'</li>' ;
                                      }
                                 }else {
                                         echo '<div class="container">';
                                               echo '<div class="nice-message">There\'s no record to show';
                                         echo "</div>";

                                }

                               ?>
                            </ul>
                          </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="panel panel-default">
                        <div class="panel-heading">
                              <i class="fa fa-tag" ></i>
                               Latest  <?php echo $numItems; ?> Items

                               <span class="toggle-info pull-right">
                                 <i class="fa fa-eye fa-lg"></i>
                               </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                              <?php

                                  if (! empty($latestItems)) {

                              foreach ($latestItems as $item) {

                                      echo '<li>';
                                              echo $item['Name'];
                                                echo  "<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "'
                                                      class='pull-right btn btn-success'>
                                                      <i class='fa fa-edit' ></i>Edit</a>";
                                                //  echo  '<a href="items.php?do=Edit&itemid="'. $item['Item_ID']  . '">';
                                              //echo '<span class="btn btn-success pull-right">';
                                                //  echo '<i class="fa fa-edit"></i> Edit';
                                                  echo "<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm pull-right '><i class='fa fa-trash-o' ></i> Delete</a>";
                                                  if ($item['Approve'] == 0) {
                                                     echo "<a  href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate pull-right'><i class='fa fa-check-square-o' ></i> Approve</a>";
                                                  }

                                              echo '</a>';
                                      echo'</li>' ;
                                  } }else {

                                                    echo '<div class="nice-message">There\'s no record to show';


                                     }
                               ?>
                            </ul>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- start latest comments -->

            <div class="row">
                  <div class="col-sm-6">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                                  <i class="fa fa-comments-o" ></i>
                                  Latest <?php echo $numComment; ?> Comments
                                  <span class="toggle-info pull-right">
                                    <i class="fa fa-plus fa-lg"></i>
                                  </span>
                            </div>
                            <div class="panel-body">
                              <?php


                                    $stmt = $con->prepare("SELECT
                                                                  comments.*,
                                                                  users.Username AS Member
                                                               FROM
                                                                   comments
                                                                INNER JOIN
                                                                   users
                                                                ON
                                                                  users.UserID = comments.user_id

                                                                ORDER BY
                                                                  c_id DESC
                                                                LIMIT $numComment
                                                                  ");
                                    $stmt->execute();
                                    $comments = $stmt->fetchall();


                                    if (! empty($comments)) {


                                    foreach ($comments as $comment ) {
                                      echo '<div class="comment-box">';
                												echo '<span class="member-n">
                													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                														' . $comment['Member'] . '</a></span>';
                												echo '<p class="member-c">' . $comment['comment'] . '</p>';
                											echo '</div>';

                                    } }else {

                                        echo '<div class="nice-message">There\'s no record to show';

                                         }

                                      ?>


                            </div>
                        </div>
                    </div>
              </div>

                <!-- end ltest comment-->

        </div>
    </div>

<?php
// END Dashboard page

   include $tpl . 'footer.php';

} else {

    header('Location: index.php');

    exit();
}

ob_end_flush();
?>
