<?php

    include("dataBase.php");
    include("functions.php");

    if(!isSuperFarmerLogin()){
        header("Location:superFarmerLogin.php");
    }

    include("header.php");

?>

<style>
    .border{
        border-radius: 50px;
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
    a{
        text-decoration: none;
    }
</style>

    <div class="col-xl-3 mt-4">
		<div class="card bg-success text-white mb-4">
			<div class="card-body">
				<h1 class="text-center"><?php echo countTotalFarmers($connection); ?></h1>
				<h5 class="text-center">Total Farmers</h5>
			</div>
		</div>
	</div>

<?php

    include("footer.php");

?>