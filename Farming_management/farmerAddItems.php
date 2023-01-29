<?php

    include("dataBase.php");
    include("functions.php");

    if(!isFarmerLogin()){
        header("Location: farmerLogin.php");
    }

    $error = '';
    $message = '';

    // <!-- ADD ITEMS -->

    if(isset($_POST["addItem"])){
        $formData = array();    
        if(empty($_POST["itemName"])){
            $error .= '<li>item Name is Required</li>';
        }
        else{
            $formData['itemName'] = trim($_POST["itemName"]);
        }
    
        if(empty($_POST["itemCategory"])){
            $error .= '<li>Category is Required</li>';
        }
        else{
            $formData['itemCategory'] = trim($_POST["itemCategory"]);
        }

        if(empty($_POST["totalItems"])){
            $error .= '<li>No. of Items is Required</li>';
        }
        else{
            $formData['totalItems'] = trim($_POST["totalItems"]);
        }

        if(empty($_POST["amount"])){
            $error .= '<li>Amount is Required</li>';
        }
        else{
            $formData['amount'] = trim($_POST["amount"]);
        }

        if(isset($_FILES['itemImg'])){

            $imgName = $_FILES['itemImg']['name'];
            $imgType = $_FILES['itemImg']['type'];
            $tmpName = $_FILES['itemImg']['tmp_name'];
            $imageSize = $_FILES['itemImg']['size'];
            $extensions = ["jpeg", "png", "jpg"];
            if(move_uploaded_file($tmpName, "farmItemsUpload/".$imgName)){
                $formData['itemImg'] = $imgName;
            }
        }
        else{
            $error .= "<li>Upload Farm's ingredient Image</li>";
        }
    
        if($error == ''){
            $data = array(
                ':itemName'		=>	$formData['itemName']
            );
    
            $query = "
            SELECT item_name FROM farm_items 
            WHERE item_name = :itemName
            AND farmer_name = '".$_SESSION['userName']."'
            ";
            $statement = $connection->prepare($query);    
            $statement->execute($data);

            if($statement->rowCount() > 0){
                $error = '<li>Product Already Exists Please Edit That For Changes</li>';
            }
            else{
                $data = array(
                    ':itemCategory'		   =>   	$formData['itemCategory'],
                    ':userName'            =>       $_SESSION['userName'],
                    ':itemName'			   =>   	$formData['itemName'],
                    ':totalItems'		   =>   	$formData['totalItems'],
                    ':amount'		       =>   	$formData['amount'],
                    ':itemImg'	           =>	    $formData['itemImg'],
                    ':itemAddedOn'		   =>   	getDateTime($connection)
                );
        
                $query = "
                    INSERT INTO farm_items 
                    (item_cat, farmer_name, item_name, total_item, amount, item_pic, item_added_on) 
                    VALUES (:itemCategory, :userName, :itemName, :totalItems, :amount, :itemImg, :itemAddedOn)
                ";
                $statement = $connection->prepare($query);    
                $statement->execute($data);

                header('Location:farmerAdditems.php?msg=add');
            }
        }
    }

    // <!-- EDIT FARM ITEMS -->

    if(isset($_POST["editFarmItem"])){
        $formData = array();

        if(empty($_POST["totalItems"])){
            $error .= '<li>Total Farm Item is Required</li>';
        }
        else{
            $formData['totalItems'] = $_POST['totalItems'];
        }

        if(empty($_POST["amount"])){
            $error .= '<li>Amount is Required</li>';
        }
        else{
            $formData['amount'] = $_POST['amount'];
        }

        if($error == ''){

            $farmId = convertData($_POST['farmId'], 'decrypt');

            $data = array(
                ':totalItems'		    =>	$formData['totalItems'],
                ':amount'		    =>	$formData['amount'],
                ':itemUpdatedOn'	=>	getDateTime($connection),
                ':farmId'			=>	$farmId
            );

            $query = "
                UPDATE farm_items 
                SET total_item = :totalItems, 
                amount = :amount,  
                item_updated_on = :itemUpdatedOn  
                WHERE id = :farmId
            ";

            $statement = $connection->prepare($query);
            $statement->execute($data);

            header('location:farmerAddItems.php?msg=edit');
        }
    }

    $query = "
        SELECT * FROM farm_items
        WHERE farmer_name = '".$_SESSION['userName']."'
        ORDER by id DESC
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
    <h1 class="mt-4 text-white">Farm Item Management</h1>
    <?php
    if(isset($_GET['action'])){

            // <!-- ADD ITEM -->

        if($_GET['action'] == 'add'){
    ?>    
            <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                <li class="breadcrumb-item"><a href="farmerServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="farmerAddItems.php" style="color: black;text-decoration:none">View Farm Items</a></li>
                <li class="breadcrumb-item active">Add Items</li>
            </ol>
            <div class="row d-flex justify-content-center">
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
                            <h4><i class="fas fa-user-plus"></i>Add New Item</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <h5><label class="form-label">Farmer Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="itemName" id="itemName" class="form-control" value="<?php echo $_SESSION['userName'] ?>" readonly/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Item Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="itemName" id="itemName" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Select Category</label></h5>
                                    <div class="center">
                                        <select name="itemCategory" id="itemCategory" class="form-control">
                                            <?php echo fillCategory($connection); ?>
                                        </select>
                                    </div>                                
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Total Item(in kg)</label></h5>
                                    <div class="center">
                                        <input type="number" name="totalItems" id="totalItems" step="1" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Price Per KG</label></h5>
                                    <div class="center">
                                        <input type="number" name="amount" id="amount" step="1" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Farm's Ingridient Image</label></h5>
                                    <div class="center">
                                        <input type="file" name="itemImg" id="itemImg" class="uploadBox" />
                                    </div>
                                </div>

                                <br>

                                <div class="mt-4 mb-0 center">
                                    <input type="submit" name="addItem" class="_btn" value="Save" />
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        else if($_GET["action"] == 'edit'){
            $farmId = convertData($_GET["code"],'decrypt');
            if($farmId > 0){
                $query = "
                    SELECT * FROM farm_items
                    WHERE id = '$farmId'
                ";
                $itemResult = $connection->query($query);
                foreach($itemResult as $row){
        ?>
                    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                        <li class="breadcrumb-item"><a href="farmerServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="farmerAddItems.php" style="color: black;text-decoration:none">View Farm Items</a></li>
                        <li class="breadcrumb-item active">Edit Farm Items</li>
                    </ol>
                    <div class="row">
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
                                    <h4><i class="fas fa-user-plus"></i>Edit Farm Item</h4>					
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="mb-3">
                                            <h5><label class="form-label">Total Items</label></h5>
                                            <div class="center">
                                                <input type="text" name="totalItems" id="totalItems" class="form-control" value="<?php echo $row['total_item']; ?>" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <h5><label class="form-label">Price Per KG</label></h5>
                                            <div class="center">
                                                <input type="text" name="amount" id="amount" class="form-control" value="<?php echo $row['amount']; ?>" />
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0 center">
                                            <input type="hidden" name="farmId" value="<?php echo $_GET['code']; ?>" />
                                            <input type="submit" name="editFarmItem" class="_btn" value="Edit" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                }
            }
        }
    }
    else{
    ?>
        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
            <li class="breadcrumb-item"><a href="farmerServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
            <li class="breadcrumb-item active">View Farm Items</a></li>
        </ol>        
        <?php
            if(isset($_GET['msg'])){

                // <!-- EDIT MSG -->
    
                if($_GET['msg'] == 'edit'){
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                            <ul class="list-unstyled">Product Availability Edited</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>     
                    ';
                }

                // <!-- ADD MSG -->

                if($_GET['msg'] == 'add'){
                    echo '
                        <div class="center">
                            <div class="alert alert-dismissible fade show alert-success" role="alert">
                                <ul class="list-unstyled">New Farm Item Added</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    ';
                }
            }

        ?>
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-center"><i class="fas fa-table me-1"></i>Farm Item Management</h4>
                <div class="row">
                    <div class="col" align="right">
                        <a href="farmerAddItems.php?action=add"><button class="addBtn">Add</button></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Farmer Name</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Total Items(in Kg)</th>
                            <th>Price Per KG</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Farmer Name</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Total Items(in Kg)</th>
                            <th>Price Per KG</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            if($statement->rowCount() > 0){
                                foreach($statement->fetchAll() as $row){
                                    echo '
                                        <tr>
                                            <td style="text-transform:capitalize">'.$row['farmer_name'].'</td>
                                            <td style="text-transform:capitalize">'.$row['item_name'].'</td>
                                            <td style="text-transform:capitalize">'.$row['item_cat'].'</td>
                                            <td>'.$row['total_item'].'</td>
                                            <td>'.currencyArray().$row['amount'].'</td>
                                            <td>'.$row['item_added_on'].'</td>
                                            <td>'.$row['item_updated_on'].'</td>
                                            <td>
                                                <a href="farmerAddItems.php?action=edit&code='.convertData($row["id"]).'" class="badge bg-primary editBtn">Edit</a>
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
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php

    include("footer.php");

?>