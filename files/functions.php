<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================



// ==========================================================
// send email by phpmailer
// ==========================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// ==========================================================
// send email by phpmailer
// ==========================================================


define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null)
{
    global $con;
    $data = array();
    if ($where == null){

        $stmt = $con->prepare("SELECT  * FROM $table ");

    }else{

        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");

    }


    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
}


function getData($table, $where = null, $values = null)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
}



function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
//     if ($json == true) {
//     if ($count > 0) {
//         echo json_encode(array("status" => "success"));
//     } else {
//         echo json_encode(array("status" => "failure"));
//     }
//   }
    return $count;
}


function updateData($table, $data, $where)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    // if ($json == true) {
    // if ($count > 0) {
    //     echo json_encode(array("status" => "success"));
    // } else {
    //     echo json_encode(array("status" => "failure"));
    // }
    // }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest)
{
  global $msgError;


  if (isset($_FILES[$imageRequest])) {
    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
    $imagesize  = $_FILES[$imageRequest]['size'];
    $allowExt   = array("jpg", "png", "gif", "webp", "jpeg");
    $strToArray = explode(".", $imagename);
    $ext        = end($strToArray);
    $ext        = strtolower($ext);

    if (!empty($imagename) && !in_array($ext, $allowExt)) {
        $msgError = "EXT";
      }
      if ($imagesize > 2 * MB) {
        $msgError = "size";
      }
      if (empty($msgError)) {
        move_uploaded_file($imagetmp,  "./upload/items/" . $imagename);
        return $imagename;
      } else {
        return "fail";
      }
    } else {
    $msgError = "File not set in the request.";
    return "fail";
}


}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 

}


function   printFailure($message = "none")
{
    echo     json_encode(array("status" => "failure" , "message" => $message));
}
function   printSuccess($message = "none")
{
    echo     json_encode(array("status" => "success" , "message" => $message));
}

function result($count){
return $count;
}


function sendEmail($email ,  $body , $subject)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'balaghikk@gmail.com'; // Update the email here
        $mail->Password = 'fafyemirojgdwgst'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('balaghikk@gmail.com'); // You may want to keep this as the sender
        $mail->addAddress($email);

        $mail->isHTML(false);
        $mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?='; // Set subject with UTF-8 encoding
        $mail->CharSet = 'UTF-8'; // Set character encoding for the email body
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->send();
        $_SESSION['email_sent'] = true;

        //        echo 'Email sent';

    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
    }
}