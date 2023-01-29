<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header('Location:superFarmerLogin.php');
    }

    $message = '';
    $error = '';

    // <!-- ADD CATEGORY-->

    if(isset($_POST['addCategory'])){
        $formData = array();
        if(empty($_POST['categoryName'])){
            $error .= '<li>Category Name is Required</li>';
        }
        else{
            $formData['categoryName'] = trim($_POST['categoryName']);
        }

        if($error == ''){
            $query = "
                SELECT * FROM category 
                WHERE cat_name = '".$formData['categoryName']."'
            ";

            $statement = $connection->prepare($query);
            $statement->execute();
            if($statement->rowCount() > 0){
                $error = '<li>Category Name Already Exists</li>';
            }
            else{
                $data = array(
                    ':categoryName'		    =>		$formData['categoryName'],
                    ':categoryCreatedOn'    =>		getDateTime($connection)
                );

                $query = "
                    INSERT INTO category 
                    (cat_name, cat_created_on)
                    VALUES (:categoryName, :categoryCreatedOn)
                ";

                $statement = $connection->prepare($query);
                $statement->execute($data);
                header('location:viewCategory.php?msg=add');
            }
        }
    }

    $query = "
        SELECT * FROM category 
        ORDER BY cat_name ASC
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
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card{
        border-radius: 50px
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
    .alert-success, .alert-danger{
        padding: 15px 45px 0px 20px;
        border-radius: 50px;
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
    a{
        text-decoration: none;
    }
</style>

<div class="container-fluid px-4" style="min-height: 700px;">
	<h1 class="mt-4 text-white">Book Category</h1>
    <?php
    if (isset($_GET['action'])) {

        // <!-- ADD CATEGORY -->
    
        if ($_GET['action'] == 'add') {
            ?>
            <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                <li class="breadcrumb-item"><a href="viewFarmer.php" style="color: black;text-decoration:none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="viewCateogry.php" style="color: black;text-decoration:none">View Category</a></li>
                <li class="breadcrumb-item active">Add Category</li>
            </ol>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if ($error != '') {
                        echo '
                                <div class="center">
                                    <div class="alert alert-dismissible fade show alert-danger" role="alert">
                                        <ul class="list-unstyled">' . $error . '</ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            ';
                    }
                    ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-center">
                            <h4><i class="fas fa-user-plus"></i>Add New Category</h4>					
                        </div>
                        <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <h5><label class="form-label">Category Name</label></h5>
                                <div class="center">
                                    <input type="text" name="categoryName" id="categoryName" class="form-control" />
                                </div>
                            </div>

                            <div class="mt-4 mb-0 center">
                                <input type="submit" name="addCategory" value="Add" class="_btn" />
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
            <li class="breadcrumb-item active">View Category</a></li>
        </ol>
        <?php 
            if(isset($_GET['msg'])){
                if($_GET['msg'] == 'add'){

                    // <!-- ADD MSG -->

                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                                <ul class="list-unstyled">New Category Added</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }
            }
        ?>

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-center"><i class="fas fa-user-edit"></i>Category</h4>
                <div class="row">
                    <div class="col" align="right">
                        <a href="viewCategory.php?action=add"><button class="addBtn">Add</button></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Category Name</th>
                            <th>Created On</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            if($statement->rowCount()>0){
                                foreach($statement->fetchAll() as $row){
                                    echo '
                                        <tr>
                                            <td style="text-transform:uppercase">'.$row["cat_name"].'</td>
                                            <td>'.$row["cat_created_on"].'</td>
                                        </tr>
                                    ';
                                }
                            }
                            else{
                                echo '
                                    <tr>
                                        <td colspan="4" class="text-center">No Data Found</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php

    include("footer.php");

?>