<?php

    include("dataBase.php");
    include("functions.php");

    $message = '';

	if(isset($_POST["loginBtn"])){
		$formdata = array();

		if(empty($_POST["userName"])){
			$message .= '<li>User Name is required</li>';
		}
		else{
            $formdata['userName'] = $_POST['userName'];
		}

		if(empty($_POST['farmerPassword'])){
			$message .= '<li>Password is Required</li>';
		}
		else{
			$formdata['farmerPassword'] = $_POST['farmerPassword'];
		}

		if($message == ''){
			$data = array(
				':userName' => $formdata['userName']
			);

			$query = "
				SELECT * FROM farmer 
				WHERE user_name = :userName
			";

			$statement = $connection->prepare($query);
			$statement->execute($data);

			if($statement->rowCount() > 0){
				foreach($statement->fetchAll() as $row){
					if ($row['farmer_status'] == 'Enable'){
						if ($row['Password'] == $formdata['farmerPassword']) {
							$_SESSION['farmerId'] = $row['farmer_id'];
							$_SESSION['userName'] = $row['user_name'];
							header('location:farmerViewOrder.php');
						} else {
							$message = '<li>Wrong Password</li>';
						}
					}
                    else{
                        $message = '<li>Your Account has been Disabled</li>';	
                    }
				}
			}	
			else{
				$message = '<li>Wrong Email Address</li>';
			}
		}
	}

	include ("header.php");

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
    @media (max-width: 786p){
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
        <div class="card-header d-flex justify-content-center"><h2>Farmer Login</h2></div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<h5><label class="form-label">User Name</label></h5>
                        <div class="center">
						    <input type="text" name="userName" id="userName" class="form-control"/>
                        </div>
					</div>

					<div class="mb-3">
						<h5><label class="form-label">Password</label></h5>
                        <div class="center">
						    <input type="password" name="farmerPassword" id="farmerPassword" class="form-control" />
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

	include ("footer.php");

?>