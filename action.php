<?php 

if(isset($_GET['action'])){
	if($_GET['action'] == 'updateStatus')
	{
		if(isset($_GET['item'])){
			include 'conn.php';
			$item = $_GET['action'];
		}
	}
}


?>