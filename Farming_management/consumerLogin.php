<?php

    include("dataBase.php");
    include("functions.php");

    $message = '';

	if(isset($_POST["loginBtn"])){
		$formdata = array();

		if(empty($_POST["userEmail"])){
			$message .= '<li>Email Address is required</li>';
		}
		else{
			if(!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)){
				$message .= '<li>Invalid Email Address</li>';
			}
			else{
				$formdata['userEmail'] = $_POST['userEmail'];
			}
		}

		if(empty($_POST['userPassword'])){
			$message .= '<li>Password is Required</li>';
		}
		else{
			$formdata['userPassword'] = $_POST['userPassword'];
		}

		if($message == ''){
			$data = array(
				':userEmail' => $formdata['userEmail']
			);

			$query = "
				SELECT * FROM user 
				WHERE user_email = :userEmail
			";

			$statement = $connection->prepare($query);
			$statement->execute($data);

			if($statement->rowCount() > 0){
				foreach($statement->fetchAll() as $row){
                    if($row['user_password'] == $formdata['userPassword']){
                        $_SESSION['consumerName'] = $row['user_name'];
                        $_SESSION['consumerEmail'] = $row['user_email'];
                        $_SESSION['consumerId'] = $row['user_id'];
                        $_SESSION['consumerAddress'] = $row['user_address'];
                        header('location:viewItemsConsumer.php');
                    }
                    else{
                        $message = '<li>Wrong Password</li>';
                    }
                }
			}	
			else{
				$message = '<li>Wrong Email Address</li>';
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
        padding: 0px 50px 0px 50px;
        margin-bottom: 10px;
        padding-top: 10px;
        border-radius: 50px;
    }
    .alert-success{
        padding: 15px 45px 0px 20px;
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
                echo '
                    <div class="center">
                        <div class="alert alert-dismissible fade show alert-danger" role="alert">
                        <ul class="list-unstyled">'.$message.'</ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                ';
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
						<h5><label class="form-label">Password</label></h5>
                        <div class="center">
						    <input type="password" name="userPassword" id="userPassword" class="form-control" />
                        </div>
					</div>

					<div class="mt-4 mb-0 center">
						<input type="submit" name="loginBtn" class="_btn" value="Login" />
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