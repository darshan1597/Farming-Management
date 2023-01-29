<?php
    include("functions.php");
    include("header.php");
?>
<style>
    .borrad{
        border-radius: 50px;
    }
    ._border{
        border: 2px solid black;
    }
    .name{
        margin-bottom: 20px;
    }
    @media (max-width: 768px){
        .responsive{
            width: 100%;
            margin-top: 50px;
        }
    }
    @media (max-width: 992px){
        .userResponsive{
            margin-top: 10px
        }
    }
</style>
<div class="container">
    <div class="row align-items-md-stretch">
        <div class="col-md-6 responsive">
            <div class="h-100 p-5 text-white bg-dark borrad">
                <h2 class="name">Super Farmer Login</h2>
                <a href="superFarmerLogin.php" class="btn btn-outline-light borrad userResponsive">Super Farmer Login</a>
            </div>
        </div>
        <div class="col-md-6 responsive">
            <div class="h-100 p-5 bg-light _border borrad">
                <h2 class="name">Farmer Login</h2>
                <a href="farmerLogin.php" class="btn btn-outline-dark borrad userResponsive">Farmer Login</a>
            </div>
        </div>
        <div class="col-md-6 responsive mt-4">
            <div class="h-100 p-5 bg-light _border borrad">
                <h2 class="name">Consumer Login</h2>
                <a href="consumerLogin.php" class="btn btn-outline-dark borrad userResponsive">Consumer Login</a>
                <a href="consumerRegister.php" class="btn btn-outline-dark borrad userResponsive">Consumer Register</a>
            </div>
        </div>
    </div>    
</div>
<div style="margin-top: 50px;">
    <?php
        include("footer.php");
    ?>
</div>