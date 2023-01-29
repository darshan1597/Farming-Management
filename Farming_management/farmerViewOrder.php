<?php

    include("dataBase.php");
    include("functions.php");

    if(!isFarmerLogin()){
        header('location:login.php');
    }

    $error = "";

    if(isset($_POST["deliveryButton"])){
        if(isset($_POST["deliveryConfirmation"])){
            $data = array(
                ':returnDateTime'     =>  getDateTime($connection),
                ':deliveryStatus'    =>  'Delivered',
                ':orderId'        =>  $_POST['orderId']
            );  

            $query = "
                UPDATE orders 
                SET delivery_date = :returnDateTime, 
                delivery_status = :deliveryStatus 
                WHERE id = :orderId
            ";
            $statement = $connection->prepare($query);
            $statement->execute($data);

            header("location:farmerViewOrder.php?msg=delivered");
        }
        else{
            $error = 'Please first confirm the checkbox';
        }
    }

    $query = "
        SELECT * FROM orders
        WHERE farmer_name = '".$_SESSION['userName']."' 
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
    ._badge{
        padding: 10px 20px;
        cursor: pointer;
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
    .returnBtn{
        border: none;
        padding: 8px 10px 8px 10px;
        border-radius: 50px;
        text-decoration: none;
        color: black;
    }
    .returnBtn:hover{
        text-decoration: none;
        color: black;
        transition: 0.5s;
        transform: scale(1.2);
        border: 1px solid black;
    }
    .returnBtn:active{
        transition: 0.5s;
        transform: scale(0.8);
    }
    .addBtn{
        border: none;
        background: #bc86db;
        padding: 8px 10px 8px 10px;
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
    img{
        border-radius: 50px;
    }
    a{
        text-decoration: none;
    }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-white">Track Orders</h1>
        <?php
        if (isset($_GET['action'])) {
            $orderId = convertData($_GET["code"], 'decrypt');

            if($orderId > 0){
                $query = "
                    SELECT * FROM orders 
                    WHERE id = '$orderId'
                ";
                $result = $connection->query($query);
                foreach($result as $row){
                    $query = "
                        SELECT * FROM user 
                        WHERE user_email = '".$row["customer_email"]."'
                    ";
                    $userResult = $connection->query($query);

                    $query = "
                        SELECT * FROM farm_items 
                        WHERE farmer_name = '".$row["farmer_name"]."'
                    ";
                    $farmItems = $connection->query($query);

                    echo '
                        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                            <li class="breadcrumb-item"><a href="farmerServices.php" style="color: black;text-decoration:none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="farmerViewOrder.php" style="color: black;text-decoration:none">View Orders</a></li>
                            <li class="breadcrumb-item active">View Order Details</li>
                        </ol>
                    ';

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

                    foreach($farmItems as $itemData){
                        echo '
                            <h2 style="color:white">Product Details</h2>
                            <table class="table table-bordered" style="color:white">
                                <tr>
                                    <th width="30%">Product Name</th>
                                    <td width="70%" style="text-transform:capitalize">'.$itemData["item_name"].'</td>
                                </tr>
                                <tr>
                                    <th width="30%">Product Category</th>
                                    <td width="70%" style="text-transform:capitalize">'.$itemData["item_cat"].'</td>
                                </tr>
                                <tr>
                                    <th width="30%">Farmer Name</th>
                                    <td width="70%" style="text-transform:capitalize">'.$itemData["farmer_name"].'</td>
                                </tr>
                            </table>
                            <br/>
                        ';
                    }

                    // <!-- USER DETAILS -->

                    foreach($userResult as $userData){
                        echo '
                            <h2 style="color:white">Customer Details</h2>
                            <table class="table table-bordered" style="color:white">
                                <tr>
                                    <th width="30%">User Email Adress</th>
                                    <td width="70%" style="text-transform:uppercase">'.$userData["user_email"].'</td>
                                </tr>
                                <tr>
                                    <th width="30%">User Name</th>
                                    <td width="70%" style="text-transform:capitaformItemlize">'.$userData["user_name"].'</td>
                                </tr>
                                <tr>
                                    <th width="30%">User Name</th>
                                    <td width="70%" style="text-transform:capitalize">'.$userData["user_address"].'</td>
                                </tr>
                            </table>
                            <br/>
                        ';
                    }

                    $status = $row["delivery_status"];
                    $formItem = '';

                    if($status == "Pending"){
                        $status = '<span class="badge _badge text-dark bg-warning">Pending</span>';
                        $formItem = '
                            <label><input type="checkbox" name="deliveryConfirmation" value="Yes" />&nbsp<span style="color:white">I aknowledge that I have delivered the product</span></label>
                            <br/>
                            <div class="mt-4 mb-4">
                                <input type="submit" name="deliveryButton" value="Deliver" class="returnBtn btn-primary" />
                            </div>
                        ';
                    }

                    if($status == 'Delivered'){
                        $status = '<span class="badge _badge text-dark bg-primary">Delivered</span>';
                    }

                    echo '
                        <h2 style="color:white">Delivery Details</h2>
                        <table class="table table-bordered" style="color:white">
                            <tr>
                                <th width="30%">Order Place On</th>
                                <td width="70%">'.$row["item_placed_on"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Delivery Status</th>
                                <td width="70%">'.$status.'</td>
                            </tr>
                            <tr>
                                <th width="30%">Total Amount</th>
                                <td width="70%">'.currencyArray().' '.$row["total_amount"].'</td>
                            </tr>
                        </table>
                        <form method="post">
                            <input type="hidden" name="orderId" value="'.$orderId.'" />
                            <input type="hidden" name="farmerName" value="'.$row["farmer_name"].'" />
                            '.$formItem.'
                        </form>
                        <br/>
                    ';
                }
            }
        }
    else{
    ?>
    <?php 
        if(isset($_GET['msg'])){
            if($_GET['msg'] == 'add')
            {
                echo '
                    <div class="center">
                        <div class="alert alert-dismissible fade show alert-success" role="alert">
                            <ul class="list-unstyled">Book Issued successfully</ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                ';
            }

            if($_GET["msg"] == 'return')
            {
                echo '
                    <div class="center">
                        <div class="alert alert-dismissible fade show alert-success" role="alert">
                            <ul class="list-unstyled">Issued Book Successfully Returned to Library</ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                ';
            }
        }
    ?>
        <div class="card border mb-4">
            <div class="card-header d-flex justify-content-center">
                <h4 class="d-flex justify-content-center"><i class="fas fa-table me-1"></i>Track Order</h4>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Customer Email</th>
                            <th>Customer Address</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Farmer Name</th>
                            <th>Item Placed On</th>
                            <th>Total Amount</th>
                            <th>Delivery Status</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Customer Email</th>
                            <th>Customer Address</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Farmer Name</th>
                            <th>Item Placed On</th>
                            <th>Total Amount</th>
                            <th>Delivery Status</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            if($statement->rowCount() > 0){
                                foreach($statement->fetchAll() as $row){
                                    echo '
                                        <tr>
                                            <td>'.$row["customer_email"].'</td>
                                            <td>'.$row["customer_address"].'</td>
                                            <td>'.$row["product_name"].'</td>
                                            <td>'.$row["quantity"].'</td>
                                            <td>'.$row["farmer_name"].'</td>
                                            <td>'.$row["item_placed_on"].'</td>
                                            <td>'.currencyArray().$row["total_amount"].'</td>
                                            <td>'.$row["delivery_status"].'</td>
                                            <td>'.$row["delivery_date"].'</td>
                                            <td>
                                                <a href="farmerViewOrder.php?action=track&code='.convertData($row["id"]).'" class="badge bg-primary editBtn">TRACK</a>
                                            </td>
                                        </tr>
                                    ';
                                }
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