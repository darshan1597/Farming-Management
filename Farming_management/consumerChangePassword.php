<?php

    include("dataBase.php");
    include("functions.php");

    if(!isConsumerLogin()){
        header("Location:consumerLogin.php");
    }

    $message = '';
    $error = '';

    if(isset($_POST['editBtn'])){
        $formData = array();

        if(empty($_POST['currentPass'])){
            $error .= '<li>Current Password is Required</li>';
        }
        else{
            $formData['currentPass'] = $_POST['currentPass'];
        }

        if(empty($_POST['newPass'])){
            $error .= '<li>New Password is Required</li>';
        }
        else{
            $formData['newPass'] = $_POST['newPass'];
        }

        if(empty($_POST['confirmPass'])){
            $error .= '<li>Confirm Password is Required</li>';
        }
        else{
            $formData['confirmPass'] = $_POST['confirmPass'];
        }

        if($error == ''){
            if($formData['newPass'] != $formData['confirmPass']){
                $error .= '<li>New Password and Confirm Password Does Not Match</li>';
            }
            else{
                $data = array(
                    ':currentPass' => $formData['currentPass']
                );

                $query = "
                    SELECT * FROM user
                    WHERE user_password = :currentPass
                ";
                $statement = $connection->prepare($query);
                $statement->execute($data);

                if($statement->rowCount() > 0){
                    foreach($statement->fetchAll() as $row){
                        $consumerId = $_SESSION['consumerId'];
                        $data = array(
                            ':newPass' => $formData['newPass'],
                            ':consumerId' => $consumerId
                        );
                        $query = "
                            UPDATE user
                            SET user_password = :newPass
                            WHERE user_id = :consumerId
                        ";
                        $statement = $connection->prepare($query);
                        $statement->execute($data);
                        $message = '<li>Password Changed</li>';
                    }
                }
                else{
                    $error = '<li>Wrong Password</li>';
                }
            }
        }
    }
    
    $query = "
        SELECT * FROM user
        WHERE user_id = '".$_SESSION["consumerId"]."'
    ";
    $result = $connection->query($query);

    include("header.php");

?>

<style>
    .border{
        border-radius: 50px;
    }
    .form-control{
        border-radius: 50px;
        width: 80%;
        padding: 10px 10px;
    }
    .form-control:focus{
        border: 2px solid black;
    }
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card{
        border-radius: 50px
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
    .alert-danger, .alert-success{
        padding: 15px 45px 0px 20px;
        border-radius: 50px;
    }
</style>

<div class="container-fluid px-4">
	<h1 class="mt-4 text-white">Change Password</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="managementServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
		<li class="breadcrumb-item active">Change Password</a></li>
	</ol>
	<div class="row d-flex align-items-center justify-content-center">
		<div class="col-md-6">
			<?php
                if($error != ''){
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-danger" role="alert">
                                <ul class="list-unstyled">'.$error.'</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }
                if($message != ''){
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                                <ul class="list-unstyled">'.$message.'</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }
			?>
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-center">
					<h4><i class="fas fa-lock"></i>Change Password</h4>
				</div>
				<div class="card-body">
                    <?php 
                        foreach($result as $row){
                    ?>
                            <form method="post">
                                <div class="mb-3">
                                    <h5><label class="form-label">Current Password</label></h5>
                                    <div class="center">
                                        <input type="password" name="currentPass" id="currentPass" class="form-control" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h5><label class="form-label">New Password</label></h5>
                                    <div class="center">
                                        <input type="password" name="newPass" id="newPass" class="form-control" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h5><label class="form-label">Confirm Password</label></h5>
                                    <div class="center">
                                        <input type="password" name="confirmPass" id="confirmPass" class="form-control" />
                                    </div>
                                </div>
                                <div class="mt-4 mb-0 center">
                                    <input type="submit" name="editBtn" class="btn _btn" value="Change Password" />
                                </div>
                                <br>
                            </form>
                    <?php 
                        }
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

    include("footer.php");

?>