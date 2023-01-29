<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header("Location:superFarmerLogin.php");
    }
    
    $query = "
        SELECT * FROM super_farmer
        WHERE id = '".$_SESSION["superFarmerId"]."'
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
        cursor: no-drop;
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
	<h1 class="mt-4 text-white">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="managementServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
		<li class="breadcrumb-item active">Profile</a></li>
	</ol>
	<div class="row d-flex justify-content-center">
		<div class="col-md-6">			
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-center">
					<h4><i class="fas fa-user-edit"></i>Profile Details</h4>
				</div>
				<div class="card-body">
                    <?php 
                        foreach($result as $row){
                    ?>
                            <form method="post">
                                <div class="mb-3">
                                    <h5><label class="form-label">User Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="usreName" id="userName" class="form-control" value="<?php echo $row['superusername']; ?>" />
                                    </div>
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