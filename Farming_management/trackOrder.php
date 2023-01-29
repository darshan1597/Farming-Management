<?php

    include("dataBase.php");
    include("functions.php");

    if(!isConsumerLogin()){
        header('location:login.php');
    }
    
    $query = "
        SELECT * FROM orders 
        WHERE customer_email = '".$_SESSION['consumerEmail']."' 
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

<div class="container-fluid px-4">
    <h1 class="mt-4 text-white">Track Orders</h1>
	<div class="card border mb-4">
		<div class="card-header d-flex justify-content-center">
            <h4 class="d-flex justify-content-center"><i class="fas fa-table me-1"></i>Track Order</h4>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Farmer Name</th>
						<th>Item Placed On</th>
						<th>Total Amount</th>
						<th>Delivery Status</th>
						<th>Delivery Date</th>
					</tr>
				</thead>
				<tfoot>
                <tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Farmer Name</th>
						<th>Item Placed On</th>
						<th>Total Amount</th>
						<th>Delivery Status</th>
						<th>Delivery Date</th>
					</tr>
				</tfoot>
				<tbody>
                    <?php 
                        if($statement->rowCount() > 0){
                            foreach($statement->fetchAll() as $row){
                                echo '
                                    <tr>
                                        <td>'.$row["product_name"].'</td>
                                        <td>'.$row["quantity"].'</td>
                                        <td>'.$row["farmer_name"].'</td>
                                        <td>'.$row["item_placed_on"].'</td>
                                        <td>'.currencyArray().$row["total_amount"].'</td>
                                        <td>'.$row["delivery_status"].'</td>
                                        <td>'.$row["delivery_date"].'</td>
                                    </tr>
                                ';
                            }
                        }
                    ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php

    include("footer.php");

?>