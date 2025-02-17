<?php
	//Include other php files
	include('DBConst.php');

	//Variables submitted
	$dayID = $_POST["dayID"];

	//Create DB connection
	$conn = new mysqli($GLOBALS['serverName'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);

	//Check connection
	if($conn->connect_error)
	{
		echo WebResponse::$ERROR;
		die("connection failed ".$conn->connect_error);		
	}
	
	//Create SQL query and link it to the DB
	$sqlQuery = "SELECT * FROM raider INNER JOIN late_raiders ON late_raiders.dayID = '".$dayID."' AND late_raiders.raiderID = raider.raiderID";
	$result = $conn->query($sqlQuery);
	$json_array = array();

	//Manage Query response
	if($result == TRUE)
	{	
		//Manage Query response
		if($result->num_rows > 0)
		{
			//output data of each row
			while($row = $result->fetch_assoc()) //Like c# dictionary, where the key is the column name
			{
				unset($row["dayID"]);
				$json_array[] = $row;
			}	
			echo json_encode($json_array);
		}
		else
		{
			echo WebResponse::$ERROR_0RESULTS;
		}
	}
	else
	{
		echo mysqli_error($conn);
		echo WebResponse::$ERROR_0RESULTS;
	}

	$conn->close();
?>

