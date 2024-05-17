<?php

/*

============================================================
=== comments page
=== you can edit | delete members from here
============================================================
*/

session_start();

  $pagetitle = 'Comments';

  if (isset($_SESSION['userses'])) {

      include 'ini.php';

        $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';

        // START MANAGE page

      if ($do == 'manage'){

                  // start manage members page

                  // select all users exept Admin

                  $stmt = $con->prepare("SELECT
                                                comments.*,
                                                items.Name  AS item ,
                                                users.Username
                                             FROM
                                                 comments
                                              INNER JOIN
                                                 items
                                              ON
                                                 items.Item_ID = comments.item_id
                                              INNER JOIN
                                                 users
                                              ON
                                                users.UserID = comments.user_id
                                              ORDER BY
                                                c_id
                                                DESC

                                                ");

                  // execute the statement

                  $stmt->execute();

                  // assign to variable

                  $rows = $stmt->fetchall();

                  if (! empty($rows)) {

                ?>

              <h1 class="text-center">Manage Comments</h1>
              <div class="container">
                    <div class="table-responsive">
                          <table class="main-table text-center table table-borderd">
                                <tr>
                                    <td>#ID</td>
                                    <td>Comment</td>
                                    <td>Item Name</td>
                                    <td>User name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>

                                <?php

                                    foreach ($rows as $row) {
                                          echo "<tr>";
                                                echo "<td>" . $row['c_id'] . "</td>" ;
                                                echo "<td>" . $row['comment'] . "</td>" ;
                                                echo "<td>" . $row['item'] . "</td>" ;
                                                echo "<td>" . $row['Username'] . "</td>" ;
                                                echo "<td>" . $row['comment_date'] ."</td>" ;

                                              echo "<td>
                                                  <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class=' btn btn-success'><i class='fa fa-edit' ></i>Edit</a>
                                                  <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-trash-o' ></i>Delete</a>";

                                                    if ($row['status'] == 0) {

                                                       echo "<a href='comments.php?do=Approve&comid=" .
                                                        $row['c_id'] . "' class='btn btn-info activate'>
                                                        <i class='fa fa-check-square-o' ></i> Activate</a>";

                                                    }

                                          echo  "</td>";
                                          echo "</tr>";
                                    }

                                 ?>

                          </table>
                    </div>
              </div>

            }
      <?php
          }else {
                 echo '<div class="container">';
                       echo '<div class="nice-message">There\'s no record to show';
                 echo "</div>";

        }  // end manage members page
               // start members page

    }elseif ($do == 'Edit') { //start edite page

          // Check if get request userid is numeric and get the integer value of it

          /*  if (isset($_GET['userid']) && is_numeric($_ ['userid'])){
              echo intval($_ ['userid']);
            }else { echo 0; }  */
            $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;

          // select all data depend on this id

            $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? LIMIT 1 ");

                // ececute query

                    $stmt->execute(array($comid));

                // FETCH THE DATA

                    $row   = $stmt->fetch();

                // the row coun

                    $count = $stmt->rowCount();

                // if there is such id show the form

                if ($count > 0) {

                   ?>

                           <h1 class="text-center">Edit Comment</h1>

                           <div class="container">
                             <form class="form-horizontal" action="comments.php?do=Update" method="POST" >
                                  <input type="hidden" name="comid" value="<?php echo $comid; ?>">
                               <!-- start comment field -->
                               <div class="form-group">
                                    <label class="col-sm-2 control-label">Comment</label>
                                    <div class="col-sm-10 col-md-4">
                                        <textarea class="form-control" name="comment" rows="8" cols="80"><?php echo $row['comment'] ; ?></textarea>
                                    </div>
                               </div>
                                   <!-- end comment field -->
                                   <!-- start username field -->
                                   <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                              <input type="submit" value="Save" class="btn btn-lg btn-primary">
                                        </div>
                                   </div>
                                    <!-- end username field -->
                             </form>



                           </div>

                           <?php

                         } else {

                              // IF THERE IS NO SUCH ID SHOW ERROR MESSAGE

                                echo "<div class='container'>";

                                      $theMsg = '<div class="alert alert-danger">Theres no such ID</div>';

                                       redirectHome($theMsg ,  4);

                                echo "</div>";

                                }
                   }  // end edit page
                   elseif ( $do == 'Update') { // start update page
                      echo '<h1 class="text-center">Update Comment</h1>';
                      echo "<div class='container'>";

                            // check if user come from forms or any page

                      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                          // Get variables from the page

                          $comment  = $_POST['comment'];
                          $comid    = $_POST['comid'];

                            // update the datebase with this info

                           $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?  ");
                           $stmt->execute(array($comment , $comid ));

                           // echo success message


                           $theMsg =  '<div class="alert alert-success">'.$stmt->rowCount() . '  Record update'.'</div>';

                             redirectHome($theMsg ,'back' );


                          } else {

                        $theMsg =  '<div class="alert alert-danger">sorry you cant browse this page dirctory</div>';

                        redirectHome($theMsg );

                          }

                          echo "</div>";

                }  // end update page

        elseif ($do =='Delete') { //  start delelt member page

            echo '<h1 class="text-center">Delete Comment</h1>';
            echo "<div class='container'>";


            // Check if get request userid is numeric and get the integer value of it

            /*  if (isset($_GET['userid']) && is_numeric($_ ['userid'])){
                echo intval($_ ['userid']);
              }else { echo 0; }  */
              $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;

                  // check user if not exesit

                      $check = checkItem('c_id' , 'comments' , $comid );

                  // if there is such id show the form

                  if ($check > 0) {


                         $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zcomment");

                         $stmt->bindParam(":zcomment" , $comid );

                         $stmt->execute();
                      // WE CAN USE THIS QUERY BUT CHING :ZUSER ? $stmt->execute(array($userid));

                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount() . '  Record delete'.'</div>';

                    redirectHome($theMsg , 'back');

                    echo '</div>';


                  }  else {


                      $error = '<div class="alert alert-danger">This ID is not exist</div>';

                      redirectHome($error);

                    }


                echo '</div>';

        }

          // end delete page

        elseif ($do == 'Approve') {



              echo '<h1 class="text-center">Approve Member</h1>';
              echo "<div class='container'>";


              // Check if get request userid is numeric and get the integer value of it

              /*  if (isset($_GET['userid']) && is_numeric($_ ['userid'])){
                  echo intval($_ ['userid']);
                }else { echo 0; }  */
                $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;

              // select all data depend on this id


                        $checkid = checkItem('c_id' , 'comments', $comid );

                    // if there is such id show the form

                    if ($checkid> 0) {


                           $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

                           $stmt->execute(array($comid));
                        // WE CAN USE THIS QUERY BUT CHING :ZUSER ? $stmt->execute(array($userid));

                      $theMsg = '<div class="alert alert-success">'.$stmt->rowCount() . '  Record update'.'</div>';

                      redirectHome($theMsg , 'back' );

                      echo '</div>';


                    }  else {


                        $error = '<div class="alert alert-danger">This ID is not exist</div>';

                        redirectHome($error);

                      }


                  echo '</div>';

        }
      include $tpl . 'footer.php';

  } else {

      header('Location: index.php');

      exit();
  }
