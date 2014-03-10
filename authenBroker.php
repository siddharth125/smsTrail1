<?php
//input:- userid,password
//output:- 0- user not authenticated
//1- user authenticated
//anything else:- error in input
?>

<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
connect();
?>

<?php
if(!empty($_GET['userid'])||!empty($_GET['password'])){
	$errors=array();
	//Valdation
	$required_fields=array('userid','password');
	$errors = array_merge($errors, check_required_fields($required_fields));
	
	$userid = trim(mysql_prep($_GET['userid']));
	$password = trim(mysql_prep($_GET['password']));
	if(empty($errors)){
		$query = "SELECT * FROM  `broker` WHERE  `userid` = '{$userid}'";
		$result_set1 = mysql_query($query);
		confirm_query($result_set1);
		$row = mysql_fetch_array($result_set1);
		if($password == $row['password']){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo "improper input data.<br/>";
	}
}else{
	echo "Data not received.<br/>";
}
?>