<?php

    include("dataBase.php");
    include("functions.php");

    $message = '';

	if(isset($_POST["loginBtn"])){
		$formData = array();

		if(empty($_POST["userEmail"])){
			$message .= '<li>Email Address is required</li>';
		}
		else{
			if(!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)){
				$message .= '<li>Invalid Email Address</li>';
			}
			else{
				$formData['userEmail'] = $_POST['userEmail'];
			}
		}

		if(empty($_POST['userName'])){
			$message .= '<li>user Name is Required</li>';
		}
		else{
			$formData['userName'] = $_POST['userName'];
		}

		if(empty($_POST['userAddress'])){
			$message .= '<li>Address is Required</li>';
		}
		else{
			$formData['userAddress'] = $_POST['userAddress'];
		}

		if(empty($_POST['userPassword'])){
			$message .= '<li>Password is Required</li>';
		}
		else{
			$formData['userPassword'] = $_POST['userPassword'];
		}

		if($message == ''){
			$data = array(
				':userEmail' => $formData['userEmail']
			);

			$query = "
				SELECT user_name FROM user 
				WHERE user_email = :userEmail
			";

			$statement = $connection->prepare($query);
			$statement->execute($data);

			if($statement->rowCount() > 0){
				$message = '<li>Email Already Exists</li>';
			}	
			else{
                $data = array(
                    ':userEmail'			=>	$formData['userEmail'],
                    ':userName'			=>	$formData['userName'],
                    ':userAddress'			=>	$formData['userAddress'],
                    ':userPassword'	    =>	$formData['userPassword'],
                );

                $query = "
                    INSERT INTO user 
                    (user_email, user_password, user_name, user_address) 
                    VALUES (:userEmail, :userPassword, :userName, :userAddress)
			    ";

                $statement = $connection->prepare($query);
                $statement->execute($data);
                header('location:consumerLogin.php?msg=success');
            }
		}
	}

    include("header.php");

?>
<style>
    .form-control{
        border-radius: 50px;
        width: 80%;
        padding: 10px 10px;
    }
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-control:focus{
        border: 2px solid black;
    }
    .card{
        border-radius: 50px;
    }
    ._btn{
        padding: 10px 0px;
        width: 50%;
        background: #bc86db;
        border-radius: 50px;
    }
    ._btn:hover{
        transition: 0.5s;
        transform: scale(1.2);
        border: 2px solid black;
    }
    ._btn:active{
        transition: 0.5s;
        transform: scale(0.8);
    }
    .alert-danger{
        padding: 0px 50px 8px 50px;
        margin-bottom: 10px;
        padding-top: 10px;
        border-radius: 50px;
    }
    @media (max-width: 992px){
        .form{
            width: 60%;
        }
    }
    @media (max-width: 786px){
        .form{
            width: 100%;
        }
    }
</style>

<div class="d-flex align-items-center justify-content-center resopnsive" style="min-height:500px;">
	<div class="col-md-6 form">

		<?php 
            if($message != ''){
                echo '<div class="center"><ul class="list-unstyled alert-danger">'.$message.'</ul></div>';
            }
		?>

		<div class="card">
        <div class="card-header d-flex justify-content-center"><h2>User Login</h2></div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<h5><label class="form-label">Email Address</label></h5>
                        <div class="center">
						    <input type="text" name="userEmail" id="userEmail" class="form-control"/>
                        </div>
					</div>
                    
					<div class="mb-3">
						<h5><label class="form-label">User Name</label></h5>
                        <div class="center">
						    <input type="text" name="userName" id="userName" class="form-control"/>
                        </div>
					</div>
                    
					<div class="mb-3">
						<h5><label class="form-label">User Address</label></h5>
                        <div class="center">
						    <input type="text" name="userAddress" id="userAddress" class="form-control"/>
                        </div>
					</div>

					<div class="mb-3">
						<h5><label class="form-label">Password</label></h5>
                        <div class="center">
						    <input type="password" name="userPassword" id="userPassword" class="form-control" />
                        </div>
					</div>

					<div class="mt-4 mb-0 center">
						<input type="submit" name="loginBtn" class="_btn" value="Register" />
					</div>
                    <br>
				</form>
			</div>
		</div>
	</div>
</div>

<?php

    include("footer.php");

?>