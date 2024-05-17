<?php
  session_start();
  $nonavbar = '';
  $pagetitle = 'Login';
  if (isset($_SESSION['userses'])) {
    header('Location: dashboard.php');    // redirect to dashboard page
  }

 include 'ini.php';


    // check if user coming from http post request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       //  $useremail = $_POST['user'];
       //  $password = $_POST['pass'];
       //  $hashpass = sha1($password);

       //  // check if user exist in database

       //  $stmt = $con->prepare("SELECT

       //                                                  *                                     FROM
       //                                users
       //                         WHERE
       //                         user_email = ?
       //                         AND
       //                         user_password = ?
       //                         AND user_type = 3
       //                         LIMIT 1 ");

       //  $stmt->execute(array($useremail , $hashpass));
       //  $row   = $stmt->fetch();
       //  $count = $stmt->rowCount();

       //  //if count > 0 this mean the datebase contain record about this Username
       //  if ($count > 0) {
       //       $_SESSION['userses'] = $row['user_name'];       // register session name
       //       $_SESSION['ID']      = $row['user_id '];  // register session ID
       //       header('Location: dashboard.php');      // redirect to dashboard page
       //        exit();


       //  }


       if (isset($_POST['login'])) {
              $password = sha1($_POST['pass']);
              $email = $_POST['email'];
        
        
        
              $stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND  user_password = ? AND user_approve = 1  ");
              $stmt->execute(array($email, $password));
              $count = $stmt->rowCount();
        
              if ($count > 0) {
                
                      ?> <script type="text/javascript">
                               Swal.fire({
                                icon: 'error',
                                 title: 'لم يتم تفعيل الحساب',
                                 showConfirmButton: false,
                                 timer: 1950,
                               })
                               </script><?php
        
                $verfiycode = rand(10000, 99999);

        
        
              }else{
                $stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND  user_password = ? AND user_approve = 2  ");
                $stmt->execute(array($email, $password));
                $count2 = $stmt->rowCount();
                $get = $stmt->fetch();
        
        
                if ($count2 > 0) {
        
                  ?>
       

<script>
    alert('تم تسجيل الدخول بنجاح');
</script>
                    <?php
        
        
                  $_SESSION['userid'] = $get['user_id']; // register user id in session
                  $_SESSION['userses'] = $get['user_name']; // register user id in session
                  $_SESSION['useremail'] = $get['user_email']; // register user id in session
                  
                  header("refresh:0.5;url=items.php");
        
        
        
                }else{
        
                    ?>     <script>
                    alert("البريد الاكتروني او كلمة المرور غير صحيحه");
                </script>
                <?php
                          header("refresh:1.5;url=index.php");
                }
        
        
              }
        
        
        
            }
        

        
}


 ?>

        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
          <h2 class="text-center">تسجيل دخول الأدارة</h4>
          <input class="form-control" type="email" name="email" placeholder="البريد الالكتروني" autocomplete="off">
          <input class="form-control"  type="password" name="pass" placeholder="كلمة المرور" autocomplete="new-password">
          <input class="btn btn-primary btn-block"  type="submit" name="login" value="login">

        </form>



 <?php include $tpl . 'footer.php';?>
