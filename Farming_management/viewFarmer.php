<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header("Location:superFarmerLogin.php");
    }

    $error = '';

    // <!-- ADD FARMER -->

    if(isset($_POST['addFarmer'])){
        $formData = array();
        if(empty($_POST['farmerName'])){
            $error .= '<li>User Name is Required</li>';
        }
        else{
            $formData['farmerName'] = trim($_POST['farmerName']);
        }

        if(empty($_POST['farmerPassword'])){
            $error .= '<li>Password is Required</li>';
        }
        else{
            $formData['farmerPassword'] = trim($_POST['farmerPassword']);
        }

        // if(isset($_FILES['itemImg'])){

        //     $imgName = $_FILES['itemImg']['name'];
        //     $imgType = $_FILES['itemImg']['type'];
        //     $tmpName = $_FILES['itemImg']['tmp_name'];
        //     $imageSize = $_FILES['itemImg']['size'];
        //     $extensions = ["jpeg", "png", "jpg"];
        //     if(move_uploaded_file($tmpName, "farmItemsUpload/".$imgName)){
        //         $formData['itemImg'] = $imgName;
        //     }
        // }

        if(!empty($_FILES['farmerImage'])){
            
            $imgName = $_FILES['farmerImage']['name'];
            $imgType = $_FILES['farmerImage']['type'];
            $tmpName = $_FILES['farmerImage']['tmp_name'];
            $imageSize = $_FILES['farmerImage']['size'];
            $extensions = ["jpeg", "png", "jpg"];
            if(move_uploaded_file($tmpName, "farmerPicUploads/".$imgName)){
                $formData['farmerImage'] = $imgName;
            }
        }
        else{
            $error .= '<li>Please Select a Profile Image</li>';
        }

        if($error == ''){
            $data = array(
                ':farmerName'		=>	$formData['farmerName']
            );
    
            $query = "
            SELECT user_name FROM farmer 
            WHERE user_name = :farmerName
            ";
            $statement = $connection->prepare($query);    
            $statement->execute($data);

            if($statement->rowCount() > 0){
                $error = '<li>User Name Already Exists</li>';
            }
            else{
                $data = array(
                    ':farmerName'			=>	$formData['farmerName'],
                    ':farmerPassword'	    =>	$formData['farmerPassword'],
                    ':farmerImage'	    =>	$formData['farmerImage'],   
                    ':farmerStatus'		=>	'Enable',
                    ':farmerCreatedOn'	=>	getDateTime($connection)
                );

                $query = "
                    INSERT INTO farmer 
                    (user_name, Password, farmer_pic, farmer_status, farmer_created_on) 
                    VALUES (:farmerName, :farmerPassword, :farmerImage, :farmerStatus, :farmerCreatedOn)
			    ";

                $statement = $connection->prepare($query);
                $statement->execute($data);
                header('location:viewFarmer.php?msg=add');
            }
        }
    }

    // <!-- SOFT DELETE FARMER -->

    if((isset($_GET["action"], $_GET["code"], $_GET["status"])) && ($_GET["action"] == 'delete')){
        $farmerId = $_GET["code"];
        $status = $_GET["status"];
        $data = array(
            ':farmerStatus'			=>	$status,
            ':farmerUpdatedOn'		=>	getDateTime($connection),
            ':farmerId'				=>	$farmerId
        );
        $query = "
            UPDATE farmer
            SET farmer_status = :farmerStatus,
            farmer_updated_on = :farmerUpdatedOn
            WHERE farmer_id = :farmerId
        ";
    
        $statement = $connection->prepare($query);    
        $statement->execute($data);
    
        header('location:viewFarmer.php?msg='.strtolower($status).'');
    }


    $query = "
        SELECT * FROM farmer
        ORDER BY farmer_id DESC
    ";
    $statement = $connection->prepare($query);
    $statement->execute();

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
    .card{
        border-radius: 50px
    }
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .badge{
        border-radius: 50px;
        border: none;
    }
    .statusBtn{
        padding: 10px 0px;
        width: 100%;
    }
    .statusBtn:hover{
        cursor:pointer;
    }
    .alert-success, .alert-danger{
        padding: 15px 45px 0px 20px;
        border-radius: 50px;
    }
    .editBtn{
        width: 100%;
        margin-bottom: 10px;
        padding: 10px 0px;
    }
    .editBtn:hover{
        color: white;
        transition: 0.5s;
        transform: scale(1.2);
        border: 2px solid black;
    }
    .editBtn:active{
        transition: 0.5s;
        transform: scale(0.8);
    }
    .addBtn{
        border: none;
        background: #bc86db;
        padding: 4px 10px 4px 10px;
        border-radius: 50px;
        text-decoration: none;
        color: black;
    }
    .addBtn:hover{
        text-decoration: none;
        color: black;
        transition: 0.5s;
        transform: scale(1.2);
        border: 1px solid black;
    }
    .addBtn:active{
        transition: 0.5s;
        transform: scale(0.8);
    }
    .alert-success, .alert-danger{
        padding: 15px 45px 0px 20px;
        border-radius: 50px;
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
    .uploadBox{
        font-size: 16px;
        background: white;
        border-radius: 50px;
        box-shadow: 5px 5px 10px black;
        width: 250px;
        outline: none;
    }
    ::-webkit-file-upload-button{
        color: white;
        background: #206a5d;
        padding: 10px;
        border: none;
        border-radius: 50px;
        box-shadow: 1px 0px 1px 1px #6b4559;
        outline: none;
    }
    ::-webkit-file-upload-button:hover{
        background: #438a5e;
        cursor: pointer;
    }
    img{
        border-radius: 50px;
    }
    a{
        text-decoration: none;
    }
</style>

<div class="container-fluid px-4" style="min-height: 700px;">
    <h1 class="mt-4 text-white">Farmer Management</h1>

    <!-- ADD FARMER -->

    <?php
    if(isset($_GET['action'])){
        if($_GET['action'] == 'add'){
    ?>
            <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                <li class="breadcrumb-item"><a href="viewFarmer.php" style="color: black;text-decoration:none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="viewFarmer.php" style="color: black;text-decoration:none">View Farmers</a></li>
                <li class="breadcrumb-item active">Add Farmer</li>
            </ol>
            <div class="row center">
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
                    ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-center">
                            <h4><i class="fas fa-user-plus"></i>Add New Farmer</h4>					
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <h5><label class="form-label">User Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="farmerName" id="farmerName" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Password</label></h5>
                                    <div class="center">
                                        <input type="text" name="farmerPassword" id="farmerPassword" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Farmer Image</label></h5>
                                    <div class="center">
                                        <input type="file" name="farmerImage" id="farmerImage" class="uploadBox" />
                                    </div>
                                </div>

                                <div class="mt-5 mb-0 center">
                                    <input type="submit" name="addFarmer" value="Add" class="_btn" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    else{
    ?>
        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
            <li class="breadcrumb-item"><a href="viewFarmer.php" style="color: black;text-decoration:none">Dashboard</a></li>
            <li class="breadcrumb-item active">Farmer Management</li>
        </ol>
        <?php
            if (isset($_GET['msg'])) {

                // <!-- DISABLE MSG -->
            
                if ($_GET["msg"] == 'disable') {
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-danger" role="alert">
                            <ul class="list-unstyled">Farmer Status Changed to Disable</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }

                // <!-- ENABLE MSG -->
            
                if ($_GET['msg'] == 'enable') {
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                            <ul class="list-unstyled">Farmer Status Changed to Enable</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }

                // <!-- ADD MSG -->
            
                if ($_GET['msg'] == 'add') {
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                            <ul class="list-unstyled">New Farmer Added</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }
            }
        ?>
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-center"><i class="fas fa-table me-1"></i>Farmers list</h4>
                    <div class="row">
                        <div class="col" align="right">
                            <a href="viewFarmer.php?action=add"><button class="addBtn">Add Farmers</button></a>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Village</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Village</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            if($statement->rowCount() > 0){
                                foreach($statement->fetchAll() as $row){
                                    $farmerStatus = '';
                                    if($row['farmer_status'] == 'Enable'){
                                        $farmerStatus = '<div class="statusBtn badge bg-success">Enable</div>';
                                    }
                                    elseif($row['farmer_status'] == 'Disable'){
                                        $farmerStatus = '<div class="statusBtn badge bg-danger">Disable</div>';
                                    }
                                    echo '
                                        <tr>
                                            <td><img src="farmerPicUploads/'.$row["farmer_pic"].'" class="" width="150px" height="150px" /></td>
                                            <td style="text-transform:capitalize">'.$row['user_name'].'</td>
                                            <td>'.$farmerStatus.'</td>
                                            <td style="text-transform:capitalize">'.$row['farm_land'].'</td>
                                            <td>'.$row['farmer_created_on'].'</td>
                                            <td>'.$row['farmer_updated_on'].'</td>
                                            <td>
                                                <button type="button" name="deleteButton" class="badge bg-danger editBtn"onclick="deleteData(`'.$row["farmer_id"].'`, `'.$row["farmer_status"].'`)">Delete</button>
                                            </td>
                                        </tr>
                                    ';
                                }
                            }
                            else{
                                echo '
                                    <tr>
                                        <td colspan="10" class="text-center">No Data Found</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
                <script>
                    function deleteData(code, status){
                        let newStatus = 'Enable'

                        if(status == 'Enable'){
                            new_status = 'Disable'
                        }
                        if(status == 'Disable'){
                            new_status = 'Enable'
                        }

                        if(confirm("Are you sure you want to "+new_status+" this Farmer?")){
                            window.location.href="viewFarmer.php?action=delete&code="+code+"&status="+new_status+"";
                        }
                    }
                </script>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php

    include("footer.php");

?>