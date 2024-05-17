<?php


/*

============================================================
=== categories page
============================================================
*/

ob_start();  // output buffering start

session_start();

$pagetitle = 'Categories';

   if (isset($_SESSION['userses'])) {

       include 'ini.php';

         $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';

         // START MANAGE page

          if ($do == 'manage'){


            $sort = 'ASC';   // WHO U WANT SORT THE Category

            $sort_array = array('ASC','DESC');

            if (isset($_GET['sort']) && in_array( $_GET['sort'] , $sort_array)) {

              $sort = $_GET['sort'];

            }

            $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

            $stmt2->execute();

            $cats = $stmt2->fetchAll(); ?>

              <h1 class="text-center">MANGE CATEGORIES</h1>
              <div class="container categories">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-edit"></i>  Manage Categories
                            <div class="option pull-right">
                                <i class="fa fa-sort"></i>  Ordering : [
                                <a class="<?php if ($sort == 'ASC'){echo'active';} ?>" href="?sort=ASC">ASC</a>
                              |  <a class="<?php if ($sort == 'DESC'){echo'active';} ?>" href="?sort=DESC">DESC </a> ]
                                <i class="fa fa-eye"></i>  View : [
                                <span class="active"  data-view="full" > Full</span>
                              | <span data-view="class"  >Classic</span> ]
                            </div>
                        </div>
                        <div class="panel-body">
                          <?php foreach ($cats as $cat) {
                            echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                    echo "<a href='categories.php?do=Edit&catid=" .$cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                    echo "<a href='categories.php?do=Delete&catid=" .$cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-trash-o'></i> Delete</a>";
                                echo "</div>";
                                echo "<h3>"                . $cat['Name']          . '</h3>' ;
                                  echo "<div class='full-view'>";
                                    echo "<p>"; if($cat['Description'] == ''){echo 'This category has no description';}else { echo $cat['Description']; } echo "<p/>" ;
                                    if ($cat['Visibility'] == 1 ){ echo '<span class="Vis1 glop"><i class="fa fa-eye"></i> Hidden</span>' ;} //  else {echo '<span class="Vis0 glop">Visibile</span>' ;  }
                                    if ($cat['Allow_Comment'] == 1 ){ echo '<span class="com1 glop" ><i class="fa fa-close"></i> Comment disable</span>' ;}  // else {echo '<span class="com0 glop">Comment enable</span>' ;  }
                                    if ($cat['Allow_Ads'] == 1 ){ echo '<span class="ads1 glop"> <i class="fa fa-close"></i> ADS disable</span>' ;}   //else {echo '<span class="ads0 glop">ADS enable</span>' ;  }
                                 echo "</div>";
                                 //get child category
                                 $childCats = getAllFrom("*", "categories", "WHERE parent = {$cat['ID']}" ,"", "ID" ,"ASC");
                                 if (! empty($childCats)) {
                                   echo "<h4 class='child-head'>Child Categories </h4>";
                                     echo "<ul class='list-unstyled child-cats'>";
                                         foreach ($childCats as $c) {
                                           echo  "<li  class='child-link'>
                                                  <a href='categories.php?do=Edit&catid=" .$c['ID'] . "' >" . $c['Name'] . "</a>
                                                  <a href='categories.php?do=Delete&catid=".$c['ID'] . "' class='show-delete confirm'> Delete</a>

                                              </li>";
                                           }
                                       echo "</ul>";
                                 }
                                 echo "<hr>";

                            echo "</div>";





                          } ?>
                        </div>
                    </div>
                    <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
              </div>
            <?php

             }
          elseif ($do == 'Add' ) { // add category page  ?>

                  <h1 class="text-center">Add new category</h1>
                  <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" >
                          <!-- start Name field -->
                      <div class="form-group ">
                           <label class="col-sm-2 control-label">Name</label>
                           <div class="col-sm-10 col-md-4">
                                 <input type="text" name="name" class="form-control"  autocomplete="off" required="recuired" placeholder="Name of the category">
                           </div>
                      </div>
                       <!-- end name field -->
                       <!-- start description field -->
                       <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-4">
                                  <input type="text" name="description" class="password form-control"  placeholder="Describe the category"/>
                            </div>
                       </div>
                        <!-- end description field -->
                        <!-- start ordering field -->
                        <div class="form-group">
                             <label class="col-sm-2 control-label">Ordering</label>
                             <div class="col-sm-10 col-md-4">
                                   <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories">
                             </div>
                        </div>
                         <!-- end ordering field -->
                         <!-- start Category Type -->
                         <div class="form-group">
                              <label class="col-sm-2 control-label">Category Type </label>
                              <div class="col-sm-10 col-md-4">
                                  <select class="form-control" name="parent">
                                          <option value="0">None</option>
                                          <?php
                                              $allCats = getAllFrom("*","categories" , "WHERE parent = 0" , "" , "ID" , "ASC" );
                                              foreach ($allCats as $cat) {
                                                  echo "<option value='" . $cat['ID'] . "'>" .  $cat['Name'] . "</option>";
                                              }
                                           ?>
                                  </select>
                              </div>
                         </div>
                         <!-- end Category Type -->
                         <!-- start Visiblility field -->
                         <div class="form-group">
                              <label class="col-sm-2 control-label">Visible</label>
                              <div class="col-sm-10 col-md-4">
                                    <div class="">
                                          <input id="vis-noy" type="radio" name="Visibility" value="0" checked/>
                                          <label for="vis-noy">Yes</label>
                                    </div>
                                    <div class="">
                                          <input id="vis-no" type="radio" name="Visibility" value="1" />
                                          <label for="vis-no">No</label>
                                    </div>
                              </div>
                         </div>
                          <!-- end Visiblility field -->
                          <!-- start commenting field -->
                          <div class="form-group">
                               <label class="col-sm-2 control-label">Allow commenting</label>
                               <div class="col-sm-10 col-md-4">
                                     <div class="">
                                           <input id="com-y" type="radio" name="commenting" value="0" checked/>
                                           <label for="com-y">Yes</label>
                                     </div>
                                     <div class="">
                                           <input id="com-no" type="radio" name="commenting" value="1" />
                                           <label for="com-no">No</label>
                                     </div>
                               </div>
                          </div>
                           <!-- end Visiblility field -->
                           <!-- start ADS field -->
                           <div class="form-group">
                                <label class="col-sm-2 control-label">Allow ADS</label>
                                <div class="col-sm-10 col-md-4">
                                      <div class="">
                                            <input id="ads-noy" type="radio" name="ads" value="0" checked/>
                                            <label for="ads-noy">Yes</label>
                                      </div>
                                      <div class="">
                                            <input id="ads-no" type="radio" name="ads" value="1" />
                                            <label for="ads-no">No</label>
                                      </div>
                                </div>
                           </div>
                            <!-- end ADS field -->
                            <!-- start button field -->
                            <div class="form-group">
                                 <div class="col-sm-offset-2 col-sm-10">
                                       <input type="submit" value="Add Category" class="btn btn-lg btn-primary">
                                 </div>
                            </div>
                             <!-- end button field -->
                    </form>



                  </div>

                  <?php

      } elseif ($do == 'Insert') { // insert category page


                        // check if user come from forms or any page

                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    echo '<h1 class="text-center">Add Category</h1>';
                    echo "<div class='container'>";

                      // Get variables from the page

                      $name     = $_POST['name'];
                      $desc     = $_POST['description'];
                      $parent   = $_POST['parent'];
                      $order    = $_POST['ordering'];
                      $visible  = $_POST['Visibility'];
                      $comment  = $_POST['commenting'];
                      $ads      = $_POST['ads'];

                      if (empty($name)) {

                        $formErrors[] = 'Full name cant be empty';

                      }else {


                      // check if category exist in database

                      $check = checkItem( "Name" ,"categories", $name);

                      if ($check == 1 ) {

                          $theMsg = '<div class="alert alert-danger">sorry this user is exist</div>';

                          redirectHome($theMsg, 'back');

                      } else {

                            // insert user category into the datebase     VALUES(:zuser, :zpass , :zmail , :zname)");

                            $stmt = $con->prepare("INSERT INTO
                                                    categories(Name, Description, parent, Ordering , Visibility , Allow_Comment , Allow_Ads )
                                                        VALUES(:zname, :zdesc, :zparent ,  :zorder , :zvisible , :zcomment , :zads )");

                            $stmt->execute(array(

                                  'zname'      => $name,
                                  'zdesc'      => $desc,
                                  'zparent'    => $parent,
                                  'zorder'     => $order,
                                  'zvisible'   => $visible,
                                  'zcomment'   => $comment,
                                  'zads'       => $ads

                            ));

                           // echo success message

                           $the =  '<div class="alert alert-success">'.$stmt->rowCount() . '  Record inserted'.'</div>';

                            redirectHome($the , 'back' , 4);

                         }

                      }



                      } else {

                          echo "<div class='container'>";


                             $error = " <div class='alert alert-danger'>sorry you cant browse this page dirctory </div>";

                             redirectHome($error , 3);

                          echo "</div>";

                      }

                      echo "</div>";


      }


        elseif ($do == 'Edit') { //statr edit category page

            // check if request category is numeric & get its integer value

            $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  intval($_GET['catid']) : 0;

          // select all data depend on this id

            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");

                // ececute query

                  $stmt->execute(array($catid));

              // FETCH THE DATA

                  $cat   = $stmt->fetch();

              // the row coun

                  $count = $stmt->rowCount();

              // if there is such id show the form

              if ($stmt->rowCount() > 0) { ?>

                                  <h1 class="text-center">Edit category</h1>
                                  <div class="container">
                                    <form class="form-horizontal" action="?do=Update" method="POST" >
                                      <input type="hidden" name="catid" value="<?php echo $catid; ?>"/>
                                          <!-- start Name field -->
                                      <div class="form-group">
                                           <label class="col-sm-2 control-label">Name</label>
                                           <div class="col-sm-10 col-md-4">
                                                 <input type="text" name="name" class="form-control" required="recuired" placeholder="Name of the category" value="<?php echo $cat['Name'] ; ?>">
                                           </div>
                                      </div>
                                       <!-- end name field -->
                                       <!-- start description field -->
                                       <div class="form-group">
                                            <label class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10 col-md-4">
                                                  <input type="text" name="description" class="password form-control"  placeholder="Describe the category" value="<?php echo $cat['Description'] ; ?>"/>
                                            </div>
                                       </div>
                                        <!-- end description field -->
                                        <!-- start ordering field -->
                                        <div class="form-group">
                                             <label class="col-sm-2 control-label">Ordering</label>
                                             <div class="col-sm-10 col-md-4">
                                                   <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories" value="<?php echo $cat['Ordering'] ; ?>"/>
                                             </div>
                                        </div>
                                         <!-- end ordering field -->
                                         <!-- start Category Type -->
                                         <div class="form-group">
                                              <label class="col-sm-2 control-label">Parent </label>
                                              <div class="col-sm-10 col-md-4">
                                                  <select class="form-control" name="parent">
                                                          <option value="0">None</option>
                                                          <?php
                                                              $allCats = getAllFrom("*","categories" , "WHERE parent = 0" , "" , "ID" , "ASC" );
                                                              foreach ($allCats as $c) {
                                                                  echo "<option value='" . $c['ID'] . "'";
                                                                      if ($cat['parent'] == $c['ID'] ) {echo " selected"; }
                                                                  echo ">" .  $c['Name'] . "</option>";
                                                              }
                                                           ?>
                                                  </select>
                                              </div>
                                         </div>
                                         <!-- end Category Type -->
                                         <!-- start Visiblility field -->
                                         <div class="form-group">
                                              <label class="col-sm-2 control-label">Visible</label>
                                              <div class="col-sm-10 col-md-4">
                                                    <div class="">
                                                          <input id="vis-noy" type="radio" name="Visibility" value="0" <?php if($cat['Visibility']== 0){echo "checked";} ?>/>
                                                          <label for="vis-noy">Yes</label>
                                                    </div>
                                                    <div class="">
                                                          <input id="vis-no" type="radio" name="Visibility" value="1" <?php if($cat['Visibility']== 1){echo "checked";} ?> />
                                                          <label for="vis-no">No</label>
                                                    </div>
                                              </div>
                                         </div>
                                          <!-- end Visiblility field -->
                                          <!-- start commenting field -->
                                          <div class="form-group">
                                               <label class="col-sm-2 control-label">Allow commenting</label>
                                               <div class="col-sm-10 col-md-4">
                                                     <div class="">
                                                           <input id="com-y" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment']== 0){echo "checked";} ?>/>
                                                           <label for="com-y">Yes</label>
                                                     </div>
                                                     <div class="">
                                                           <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment']== 1){echo "checked";} ?> />
                                                           <label for="com-no">No</label>
                                                     </div>
                                               </div>
                                          </div>
                                           <!-- end Visiblility field -->
                                           <!-- start ADS field -->
                                           <div class="form-group">
                                                <label class="col-sm-2 control-label">Allow ADS</label>
                                                <div class="col-sm-10 col-md-4">
                                                      <div class="">
                                                            <input id="ads-noy" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads']== 0){echo "checked";} ?>/>
                                                            <label for="ads-noy">Yes</label>
                                                      </div>
                                                      <div class="">
                                                            <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads']== 1){echo "checked";} ?>/>
                                                            <label for="ads-no">No</label>
                                                      </div>
                                                </div>
                                           </div>
                                            <!-- end ADS field -->
                                            <!-- start button field -->
                                            <div class="form-group">
                                                 <div class="col-sm-offset-2 col-sm-10">
                                                       <input type="submit" value="SAVE" class="btn btn-lg btn-primary">
                                                 </div>
                                            </div>
                                             <!-- end button field -->
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


            }

              elseif ( $do == 'Update') {

                // start update page
                  echo '<h1 class="text-center">Update Category</h1>';
                  echo "<div class='container'>";

                        // check if user come from forms or any page

                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                      // Get variables from the page

                      $id    = $_POST['catid'];
                      $name  = $_POST['name'];
                      $desc  = $_POST['description'];
                      $order = $_POST['ordering'];
                      $parent = $_POST['parent'];
                      $visible  = $_POST['Visibility'];
                      $comment  = $_POST['commenting'];
                      $ads      = $_POST['ads'];

                       // update the datebase with this info

                       $stmt = $con->prepare("UPDATE
                                                  categories
                                              SET Name = ? ,
                                                  Description = ? ,
                                                  Ordering = ? ,
                                                  parent = ? ,
                                                  Visibility = ?,
                                                  Allow_Comment = ?,
                                                  Allow_Ads   = ?
                                                   WHERE ID = ?  ");
                       $stmt->execute(array($name,$desc, $order, $parent ,$visible ,$comment ,$ads ,$id ));

                       // echo success message

                       $theMsg =  '<div class="alert alert-success">'.$stmt->rowCount() . '  Record update'.'</div>';

                         redirectHome($theMsg ,'back');


                      } else {

                    $theMsg =  '<div class="alert alert-danger">sorry you cant browse this page dirctory</div>';

                    redirectHome($theMsg );

                      }

                      echo "</div>";

              // end update page


          } elseif ($do =='Delete') {

                // start category member page

                    echo '<h1 class="text-center">Delete Category</h1>';
                    echo "<div class='container'>";


                    // Check if get request userid is numeric and get the integer value of it

                    /*  if (isset($_GET['userid']) && is_numeric($_ ['userid'])){
                        echo intval($_ ['userid']);
                      }else { echo 0; }  */
                      $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  intval($_GET['catid']) : 0;

                    // select all data depend on this id


                    $checkid = checkItem('ID' , 'categories' , $catid);

                    //if there is such ID show form

                    if ($checkid > 0) {

                      $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

                      $stmt->bindParam(":zid" , $catid );

                      $stmt->execute();
                   // WE CAN USE THIS QUERY BUT CHING :ZUSER ? $stmt->execute(array($userid));

                 $theMsg = '<div class="alert alert-success">'.$stmt->rowCount() . '  Record delete'.'</div>';

                 redirectHome($theMsg , 'back' ,4);

                 echo '</div>';


                    }
                    else {


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

ob_end_flush(); // Release the Output

?>
