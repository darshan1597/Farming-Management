<?php

    include("dataBase.php");
    include("functions.php");

    if(!isFarmerLogin()){
        header("Location: farmerLogin.php");
    }

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
    <h1 class="mt-4 text-white">
        Total Amount
    </h1>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="farmerViewOrder.php" style="color: black;text-decoration:none">Dashboard</a></li>
        <li class="breadcrumb-item active">Total Amount</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="d-flex justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="35" fill="currentColor" class="bi bi-cash-stack mr-4" viewBox="0 0 16 16">
                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                </svg>
                Amount
            </h4>
        </div>
        <div class="card-body">
            <div style="color:dark; font-weight: bolder; font-size: larger">
                Total Amount Recieved till <?php echo ''.getDateTime($connection).' is '.currencyArray().countTotalAmountReceived($connection).'' ?>
            </div>
        </div>
    </div>
</div>

<?php

    include("footer.php");

?>