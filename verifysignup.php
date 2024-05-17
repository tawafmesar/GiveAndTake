<?php
ob_start();
session_start();


include 'files/ini.php';






if( isset($_SESSION['email']) ){

  $email =  $_SESSION['email'];


?>

<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
<link rel='stylesheet' href='css/login.css'>



	<div class="section ltrr">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
			          	<label for="reg-log"></label>

						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">										
                                        <form id="verifyForm" class="section text-center drtt" action="checkcodesignup.php" method="post" style="flex-direction:inherit;">
                                                        <h4 class="mb-4 pb-3"> تأكيد البريد الألكتروني</h4>
                                                                <h2>ادخل رمز التحقق الذي تم ارسالة الى بريدك الألكتروني</h2>
                                                                <h4><?php echo   $email ; ?></h4>           
                                            <input type="text"style="  width: 50px; text-align: center;   line-height: normal;" autofocus name="code[]" maxlength="1" pattern="[0-9]" required oninput="moveToNext(this, 1)">
                                            <input type="text" style="  width: 50px; text-align: center;   line-height: normal;"  name="code[]" maxlength="1" pattern="[0-9]" required oninput="moveToNext(this, 2)">
                                            <input type="text" style="  width: 50px; text-align: center;   line-height: normal;" name="code[]" maxlength="1" pattern="[0-9]" required oninput="moveToNext(this, 3)">
                                            <input type="text" style="  width: 50px; text-align: center;  line-height: normal;" name="code[]" maxlength="1" pattern="[0-9]" required oninput="moveToNext(this, 4)">
                                            <input type="text" style="  width: 50px; text-align: center;  line-height: normal;" name="code[]" maxlength="1" pattern="[0-9]" required oninput="moveToNext(this, 0)">
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

    <script src="./js/login.js"></script>

<script>
        const verificationFields = document.querySelectorAll('input');

        function moveToNext(currentField, nextFieldIndex) {
            const maxLength = parseInt(currentField.getAttribute('maxlength'));

            if (currentField.value.length >= maxLength) {
                const nextField = verificationFields[nextFieldIndex];
                if (nextField) {
                    nextField.focus();
                }
            }
        }

        // Function to check if all fields are filled
        function allFieldsFilled() {
            return Array.from(verificationFields).every(field => field.value !== '');
        }

        // Function to handle form submission
        function handleFormSubmission() {
            if (allFieldsFilled()) {
            const codeValues = Array.from(verificationFields).map(field => parseInt(field.value, 10));
             verifyForm.elements["code[]"].value = codeValues; 
             verifyForm.submit();            }
        }

        // Attach event listeners to each input field to handle the input
        verificationFields.forEach(field => {
            field.addEventListener('input', handleFormSubmission);
        });
    </script>
</body>

</html>


<?php

}else{

    header('Location:login.php');

}


ob_end_flush();
?>