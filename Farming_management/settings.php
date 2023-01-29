<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header('location:superFarmerLogin.php');
    }
    $message = '';

    if(isset($_POST['editSetting'])){
        $data = array(
            ':currency'			=>	$_POST['currency'],
            ':timezone'			=>	$_POST['timezone'],
        );

        $query = "
            UPDATE settings
            currency = :currency,
            time_zone = :timezone,
        ";

        $statement = $connection->prepare($query);
        $statement->execute($data);

        $message = '
            <div class="center">
                <div class="alert alert-dismissible fade show list-unstyled alert-success" role="alert">
                    <ul>Data Edited</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        ';
    }

    $query = "
        SELECT * FROM settings
        LIMIT 1
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
        border: none;
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
    .alert-success{
        padding: 15px 45px 0px 0px;
        border-radius: 50px;
    }
</style>

<div class="container-fluid px-4">
	<h1 class="mt-4 text-white">Setting</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="superFarmerServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</a></li>
	</ol>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
	        <?php
                if($message != ''){
                    echo $message;
                }
            ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center">
                    <h4><i class="fas fa-user-edit"></i>Settings</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <h5><label class="form-label">Currency</label></h5>
                            <div class="center">
                                <select name="currency" id="currency" class="form-control">
                                <?php echo currencyList(); ?>
                                </select>
                            </div>                                
                        </div>

                        <div class="mb-3">
                            <h5><label class="form-label">Timezone</label></h5>
                            <div class="center">
                                <select name="timezone" id="timezone" class="form-control">
                                    <?php echo timezoneList(); ?>
                                </select>
                            </div>

                        <div class="mt-4 mb-0 center">
                            <input type="submit" name="editSetting" class="_btn" value="Save" />
                        </div>
                        <br>

                        <script type="text/javascript">

                            document.getElementById('currency').value = "<?php echo $row['currency']; ?>";
                            document.getElementById('timezone').value="<?php echo $row['time_zone']; ?>"; 

                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    include("footer.php");

?>