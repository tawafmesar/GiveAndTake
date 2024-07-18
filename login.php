
<?php
ob_start();
session_start();

  include 'files/ini.php';

if (isset($_SESSION['username'])) {
  header('Location: index.php');

  exit();
}

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['login'])) {
      $password = sha1($_POST['password']);
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

        $data = array("user_verifycode" => $verfiycode);
        updateData("users", $data, "user_email = '$email'");

        sendEmail($email, "قم بتفعيل حسابك عن طريق رمز التحقق التالي :  $verfiycode", "رمز التحقق");

        $_SESSION['email'] = $email; 

       header("refresh:1.8;url=verifysignup.php");


      }else{
        $stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? AND  user_password = ? AND user_approve = 2  ");
        $stmt->execute(array($email, $password));
        $count2 = $stmt->rowCount();
        $get = $stmt->fetch();


        if ($count2 > 0) {

          ?>
            <script type="text/javascript">
            Swal.fire({
              title: 'تم تسجيل الدخول بنجاح',
              icon: 'success',
              showConfirmButton: false,
              timer: 1950,            })
            </script>
            <?php


          $_SESSION['userid'] = $get['user_id']; // register user id in session
          $_SESSION['user'] = $get['user_name']; // register user id in session
          $_SESSION['useremail'] = $get['user_email']; // register user id in session
          $_SESSION['type'] = $get['user_type']; // register user id in session

          header("refresh:1.5;url=index.php");



        }else{

            ?>       <script type="text/javascript">
            Swal.fire({
             icon: 'error',
              title: ' البريد الاكتروني او كلمة المرور غير صحيحه ',
              showConfirmButton: false,
              timer: 1950,
            })

            </script><?php
                  header("refresh:1.5;url=login.php");
        }


      }



    }

    if (isset($_POST['signup'])) {




    $formErrors = array();


      // signup signup signup signup 


      $type = $_POST['type'];

      $username = $_POST['username'];


      
      $password = sha1($_POST['password']);

      $email = $_POST['email'];
      $userphone = $_POST['userphone'] ;

      $verfiycode = rand(10000, 99999);

      $stmt = $con->prepare("SELECT * FROM users WHERE user_email = ? ");
      $stmt->execute(array($email));
      $count = $stmt->rowCount();


      if ($count > 0) {

        ?>       <script type="text/javascript">
        Swal.fire({
         icon: 'error',
          title: ' البريد الألكنروني الذي ادخلته موجود مسبقاً ',
          showConfirmButton: false,
          timer: 1950,
        })

        </script><?php
        
        header("refresh:1.5;url=login.php");



      } else {
        
        $data = array(
          "user_type" => $type,
          "user_name" => $username,
          "user_password" => $password,
          "user_email" => $email,
          "user_phone" => $userphone,

          "user_verifycode" => $verfiycode,
        );

        sendEmail($email, "قم بتفعيل حسابك عن طريق رمز التحقق التالي :  $verfiycode", "رمز التحقق");

        $countt = insertData("users", $data);

        if ($countt > 0 ){

          $_SESSION['email'] = $email; // register session name
          $_SESSION['approve'] = 1; // register user id in session

          header('Location:verifysignup.php');

        }
      }


    }


  }


  ?>

<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
<link rel='stylesheet' href='css/login.css'>



	<div class="section ltrr">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3 drtt"><span>إنشاء الحساب</span><span> تسجيل الدخول</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<form class="section text-center drtt" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
											<h4 class="mb-4 pb-3">تسجيل الدخول</h4>
											<div class="form-group">
												<input type="text" name="email" class="form-style drtt" placeholder="البريد الألكتروني" id="logemail" autocomplete="off">
												<i class="input-icon uil uil-at"></i>
			  								</div>
											<div class="form-group mt-2">
						 						<input type="password" name="password" class="form-style" placeholder="كلمة السر" id="logpass" autocomplete="off">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
                      <input type="submit" name="login" class="btn mt-4"  value="تسجيل الدخول">

                    </form>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<form class="section text-center drtt" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateForm()">
											<h4 class="mb-1 pb-2">إنشاء حساب</h4>

                      <select name="type" class="form-style "
                                                        style="padding-left:12px; font-weight:300; cursor: pointer; letter-spacing:1px; border: solid 0px #fff;"
                                                required name="category" >
                          <option value="">حدد نوع المستخدم</option>
                          <option value="1">معطي</option>
                          <option value="2">أخذ</option>
                      </select>
											<div class="form-group mt-3">
												<input type="text" name="username" class="form-style" placeholder="اسم المستخدم" id="logname" autocomplete="off">
												<i class="input-icon uil uil-user"></i>
											</div>

											<div class="form-group mt-2 ">
												<input type="email" name="email" class="form-style drtt" placeholder="الأيميل" id="logemail" autocomplete="off">
												<i class="input-icon uil uil-at"></i>
											</div>

                      <div class="form-group mt-2">
                            <input type="text"  id="userphone" name="userphone" class="form-style" placeholder="رقم الجوال" autocomplete="off">			<i class="input-icon uil uil-phone"></i>
											</div>

											<div class="form-group mt-2">
                      <input type="password"  id="logpass" name="password" class="form-style" placeholder="كلمة المرور"  autocomplete="off">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>

                      <input type="submit" name="signup" class="btn mt-4"  value="إنشاء حساب جديد">
				      					</form>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function validateForm() {
    var passwordd = document.getElementById("logpass").value;
    var repassword = document.getElementById("relogpass").value;

    console.log("Password:", passwordd);
    console.log("Re-entered Password:", repassword);

    if (passwordd !== repassword) {
      alert("كلمة السر وتأكيد كلمة السر غير متطابقين");
      return false;
    }

    return true;
  }
});

</script>

<?php




  include 'files/footer.php';
  ob_end_flush();
  ?>
