<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header("Location:superFarmerLogin.php");
    }

    $query = "
        SELECT * FROM farm_items
        ORDER BY id DESC
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
    .badge{
        border-radius: 50px;
        border: none;
    }
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .statusBtn{
        padding: 10px 0px;
        width: 100%;
    }
    .statusBtn:hover{
        cursor:pointer;
    }
    .btn{
        padding: 10px;
    }
    .btn:hover{
        transition: 0.5s;
        transform: scale(1.2);
        border: 2px solid black;
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
    .requestBtn:hover{
        border: 1px solid black;
        transition: 0.5s;
        transform: scale(1.2);
    }
    .requestBtn:active{
        border: 1px solid black;
        transition: 0.5s;
        transform: scale(0.8);
    }
    a{
        text-decoration: none;
    }
</style>

<div class="container-fluid px-4" style="min-height: 700px;">
    <h1 class="mt-4 text-white">Search Farm Items</h1>
    <?php

        if(isset($_GET['action'])){

            if ($_GET["action"] == 'placeOrder') {
                $itemName = $_GET["name"];
                $farmerName = $_GET["farmer"];
                $amount = $_GET['amount'];
    ?>
                <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                <li class="breadcrumb-item"><a href="viewItemsConsumerServices.php" style="color: black;text-decoration:none">View Farm Items</a></li>
                <li class="breadcrumb-item active">Place Order</li>
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
                            <h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop mb-1" viewBox="0 0 16 16">
                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                                </svg>
                                Place Order
                            </h4>					
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <h5><label class="form-label">Farm Item Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="itemName" id="itemName" class="form-control" value="<?php echo $itemName ?>" readonly/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Our Farm <?php echo $itemName ?> Image</label></h5>
                                    <div class="center">
                                        <?php
                                            if($statement->rowCount() > 0){
                                                foreach($statement->fetchAll() as $row){
                                                echo '
                                                        <img src="farmItemsUpload/'. $row["item_pic"] .'" class="" width="150px" height="150px" style="border-radius:30px"/>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Farmer Name</label></h5>
                                    <div class="center">
                                        <input type="text" name="farmerName" id="farmerName" class="form-control" value="<?php echo $farmerName ?>" readonly/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Amount Per KG</label></h5>
                                    <div class="center">
                                        <input type="text" name="amount" id="amount" class="form-control" value="<?php echo $amount ?>" readonly/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">How Many KG's</label></h5>
                                    <div class="center">
                                        <input type="number" name="quantity" id="quantity" onkeyup="mult(this.value)" value="" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5><label class="form-label">Total Amount</label></h5>
                                    <div class="center">
                                        <input type="text" name="totAmount" id="totAmount" class="form-control" value="" readonly/>
                                    </div>
                                </div>

                                <div class="mt-5 mb-0 center">
                                    <input type="submit" name="buyNow" value="BUY NOW" class="_btn" />
                                </div>
                            </form>
                            <script>
                                function mult(value){
                                    let bill = <?php echo $amount ?> * value
                                    document.getElementById('totAmount').value = bill
                                }
                            </script>
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
            <li class="breadcrumb-item active">Search Farm items</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-center"><i class="fas fa-table me-1"></i>Farm Items List</h4>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Farmer Name</th>
                            <th>Available(in KG)</th>
                            <th>Price Per KG</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product Image</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Farmer Name</th>
                            <th>Available(in KG)</th>
                            <th>Price Per KG</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            if($statement->rowCount() > 0){
                                foreach($statement->fetchAll() as $row){
                                    echo '
                                        <tr>
                                            <td><img src="farmItemsUpload/'.$row["item_pic"].'" style="border-radius:30px;" class="" width="150px" height="150px" /></td>
                                            <td style="text-transform:capitalize">'.$row['item_name'].'</td>
                                            <td style="text-transform:capitalize">'.$row['item_cat'].'</td>
                                            <td style="text-transform:capitalize">'.$row['farmer_name'].'</td>
                                            <td style="text-transform:capitalize">'.$row['total_item'].'</td>
                                            <td style="text-transform:capitalize">'.currencyArray().$row['amount'].'</td>
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