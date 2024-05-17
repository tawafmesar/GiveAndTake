<?php
ob_start();
session_start();


include 'files/ini.php';


if( isset($_SESSION['user']) ){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
$msgError = array()  ;

$table = "items";
$userID = $_SESSION['userid'];

$name = filterRequest("name");

$desc = filterRequest("desc"); 

$category = filterRequest("category");  
 
$imagename = imageUpload("files") ;

$items_owner_show = filterRequest("show");  
 

// Printing variable values
// echo "User ID: " . $userID . "<br>";
// echo "Name: " . $name . "<br>";
// echo "Description: " . $desc . "<br>";
// echo "category: " . $category . "<br>";
// echo "Image Name: " . $imagename . "<br>";
// echo "Items Owner Show: " . ($items_owner_show ? "Yes" : "No") . "<br>";


$data = array( 
"items_name"            => $name,
"items_desc"            => $desc,
"items_image"           => $imagename,
"items_status"          => "1",
"items_cat"             => $category,
"items_owner"           => $userID,
"items_owner_show"        => $items_owner_show
);

$count =  insertData($table , $data);
if ($count > 0) {

    
          ?>
            <script type="text/javascript">
            Swal.fire({
              title: 'تم إضافة القطعة بنجاح',
              icon: 'success',
              showConfirmButton: false,
              timer: 1950,            })
            </script>
            <?php

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
						<h6 class="mb-0 pb-3 drtt"><span> التبرع بقطعة</span></h6>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front" style="height: 115%;">
									<div class="center-wrap">
										<form class="section text-center drtt" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data">
											<div class="form-group">
												<input type="text" name="name" class="form-style drtt" placeholder="الأسـم" id="logemail" autocomplete="off">
												<i class="input-icon uil-gift"></i>
			  								</div>
                                              <div class="form-group mt-2">
						 						<input type="text" name="desc" class="form-style" placeholder="الوصـف" id="logpass" autocomplete="off">
												<i class="input-icon uil-align-alt"></i>
											</div>
                                            <div class="form-group mt-2">
                                            <select name="category" class="form-style" id="logpass">
                                                <option value="" disabled selected>اختر التصنيف</option>
                                                <option value="1">أثاث</option>
                                                <option value="2">منزليات</option>
                                                <option value="3">ملابس</option>
                                            </select>
                                            <i class="input-icon   uil-apps"></i>
                                        </div>
											<div class="form-group mt-2">
                                            <div class="row mt-2" style="text-align:justify;">
                                                    <div class="col-md-12 mt-6 mt-md-0">
                                                        <label class="lbl"> ظهور اسم المالك :</label>
                                                        <input type="radio" class="rad" id="yes" name="show" value="1" >
                                                            <label  class="lbl"  for="yes"  >نعم</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" class="rad" checked id="no" name="show" value="2">
                                                            <label  class="lbl" for="no">لا</label>

                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group mt-2">
                                                    <div class="row mt-2" style="text-align:justify;     border-top: solid #ffeba7;">
                                                    <!-- Column for Image Upload -->
                                                    <div class="col-md-12">
                                                        <label class="lbl" for="imageUpload">ارفع الصورة هنا ... </label>
                                                        <input type="file" name="files" id="imageUpload" class="form-control">
                                                    </div>

                                                    
                                                </div>
                                            </div>



                                       <input type="submit" name="add" class="btn mt-4"  value="أضافة">

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


</body>

</html>


<?php

}else{

    header('Location:login.php');

}



  include 'files/footer.php';
  ob_end_flush();
  ?>
