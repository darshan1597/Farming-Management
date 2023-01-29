<?php
    function isSuperFarmerLogin(){
        if(isset($_SESSION['superFarmerId'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

    function isFarmerLogin(){
        if(isset($_SESSION['farmerId'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

    function isConsumerLogin(){
        if(isset($_SESSION['consumerId'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

    function getDateTime($connection){
		setTimezone($connection);
		return date("d-m-Y");
	}

    function setTimezone($connection){
		$query = "
			SELECT time_zone FROM settings 
			LIMIT 1
		";
		$result = $connection->query($query);
		foreach($result as $row){
			date_default_timezone_set($row["time_zone"]);
		}
	}
	
	function countTotalAmountReceived($connection){
		$total = 0;	
		$query = "
			SELECT SUM(total_amount) AS Total FROM orders 
			WHERE delivery_status = 'Delivered'
			AND farmer_name = '".$_SESSION['userName']."'
		";	
		$result = $connection->query($query);	
		foreach($result as $row){
			$total = $row["Total"];
		}
	
		return $total;
	}

	function convertData($string, $action = 'encrypt'){
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'ZFH56OIS6RM12IHROPZY87UNQO28';
		$secret_iv = '4td6aftHuS5';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt'){
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} 
		else if ($action == 'decrypt'){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	function fillCategory($connection){
		$query = "
			SELECT cat_name FROM category
			ORDER BY cat_name ASC
		";	
		$result = $connection->query($query);	
		$output = '<option value="">Select Category</option>';	
		foreach($result as $row){
			$output .= '<option value="'.$row["cat_name"].'">'.$row["cat_name"].'</option>';
		}	
		return $output;
	}

    function currencyArray(){
		$currency = array(
			'code' => 'INR',
			'countryname' => 'India',
			'name' => 'Indian rupee',
			'symbol' => '&#8377;'
		);		
		return $currency['symbol'];
	}

	function getCurrencySymbol($connection){
		$output = '';
		
		return $output;
	}

    function timezoneList()
	{
		$timezones = array(
			'Asia/Calcutta' => '(GMT+5:30) Asia/Calcutta (India Standard Time)',
			'Africa/Gaborone' => '(GMT+2:00) Africa/Gaborone (Central African Time)',
			'Africa/Harare' => '(GMT+2:00) Africa/Harare (Central African Time)',
			'Africa/Johannesburg' => '(GMT+2:00) Africa/Johannesburg (South Africa Standard Time)',
			'Africa/Kigali' => '(GMT+2:00) Africa/Kigali (Central African Time)',
			'Africa/Lubumbashi' => '(GMT+2:00) Africa/Lubumbashi (Central African Time)',
			'Africa/Lusaka' => '(GMT+2:00) Africa/Lusaka (Central African Time)',
			'Africa/Maputo' => '(GMT+2:00) Africa/Maputo (Central African Time)',
			'Africa/Maseru' => '(GMT+2:00) Africa/Maseru (South Africa Standard Time)',
			'Africa/Mbabane' => '(GMT+2:00) Africa/Mbabane (South Africa Standard Time)',
			'Africa/Tripoli' => '(GMT+2:00) Africa/Tripoli (Eastern European Time)',
			'Asia/Amman' => '(GMT+2:00) Asia/Amman (Eastern European Time)',
			'Asia/Beirut' => '(GMT+2:00) Asia/Beirut (Eastern European Time)',
			'Asia/Damascus' => '(GMT+2:00) Asia/Damascus (Eastern European Time)',
			'Asia/Gaza' => '(GMT+2:00) Asia/Gaza (Eastern European Time)',
			'Asia/Istanbul' => '(GMT+2:00) Asia/Istanbul (Eastern European Time)',
			'Asia/Jerusalem' => '(GMT+2:00) Asia/Jerusalem (Israel Standard Time)',
			'Asia/Nicosia' => '(GMT+2:00) Asia/Nicosia (Eastern European Time)',
			'Africa/Kampala' => '(GMT+3:00) Africa/Kampala (Eastern African Time)',
			'Africa/Khartoum' => '(GMT+3:00) Africa/Khartoum (Eastern African Time)',
			'Africa/Mogadishu' => '(GMT+3:00) Africa/Mogadishu (Eastern African Time)',
			'Africa/Nairobi' => '(GMT+3:00) Africa/Nairobi (Eastern African Time)',
			'Antarctica/Syowa' => '(GMT+3:00) Antarctica/Syowa (Syowa Time)',
			'Asia/Aden' => '(GMT+3:00) Asia/Aden (Arabia Standard Time)',
			'Asia/Baghdad' => '(GMT+3:00) Asia/Baghdad (Arabia Standard Time)',
			'Asia/Bahrain' => '(GMT+3:00) Asia/Bahrain (Arabia Standard Time)',
			'Asia/Kuwait' => '(GMT+3:00) Asia/Kuwait (Arabia Standard Time)',
			'Asia/Qatar' => '(GMT+3:00) Asia/Qatar (Arabia Standard Time)',
        );

		$html = '<option value="">Select Timezone</option>';
		foreach($timezones as $keys => $values)
		{
			$html .= '<option value="'.$keys.'">'.$values.'</option>';
		}
		
		return $html;
	}

	function countTotalFarmers($connection){
		$total = 0;
		$query = "
			SELECT COUNT(farmer_id) AS Total FROM farmer 
			WHERE farmer_status = 'Enable'
		";	
		$result  = $connection->query($query);	
		foreach($result as $row){
			$total = $row["Total"];
		}	
		return $total;
	}

?>