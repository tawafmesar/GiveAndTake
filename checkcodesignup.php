<?php
ob_start();
session_start();


include 'files/ini.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_SESSION['email']) && $_SESSION['approve'] == 1 ) {



        $email = $_SESSION['email']; // register session name

        $code = $_POST['code'];




        $concatenatedValue = implode("", $code);



        // Function to check if all fields are filled
        function allFieldsFilled($verfiy)
        {
            return count($verfiy) === 5 && !in_array(0, $verfiy);
        }

        // Check if all fields are filled


            $stmt = $con->prepare("SELECT * FROM users WHERE user_email = '$email' AND user_verifycode = '$concatenatedValue' ");

            $stmt->execute();

            $count = $stmt->rowCount();

            if ($count > 0) {

                $data = array("user_approve" => "2");

                updateData("users", $data, "user_email = '$email' ");
                
                    $_SESSION['approve'] = 2 ; // register user id in session


                        ?>
                        <script type="text/javascript">
                        Swal.fire({
                            title: ' تم تفعيل الحساب بنجاح',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1950,            })
                        </script>
                        <?php


            header("refresh:1.8;url=login.php");



            } else {

                        ?> <script type="text/javascript">
                        Swal.fire({
                         icon: 'error',
                          title: ' رمز التأكيد الذي ادخلته غير صحيح',
                          showConfirmButton: false,
                          timer: 1950,
                        })
                        </script><?php
                        
                       header("refresh:1.8;url=verifysignup.php");

                exit;

            }


  

    } else {

    header('Location: login.php');

    exit();


}

   

} else {

    header('Location: index.php');

    exit();


}
ob_end_flush();

?>