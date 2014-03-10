<?php
//input:- name,college,phone,email
//output:- an integer which is the userid
//anything else:- error in input
?>

<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
connect();
?>

<?php
if(!empty($_GET['name'])||!empty($_GET['college'])||!empty($_GET['phone'])||!empty($_GET['email'])){
	$errors=array();
	//Valdation
	$required_fields=array('name','college','phone','email');
	$errors = array_merge($errors, check_required_fields($required_fields));
	
	$name = trim(mysql_prep($_GET['name']));
	$college = trim(mysql_prep($_GET['college']));
	$phone = trim(mysql_prep($_GET['phone']));
	$email = trim(mysql_prep($_GET['email']));

	if(empty($errors)){
		$query = "INSERT INTO `sms`.`users` (`name`, `college`, `phone`, `email`) VALUES ('{$name}', '{$college}', '{$phone}', '{$email}')";
		
		$result_set = mysql_query($query);

		if($result_set){
			$query = "SELECT * FROM  `users` WHERE  `name` = '{$name}'";
			$result_set1 = mysql_query($query);
			confirm_query($result_set1);
			$row = mysql_fetch_array($result_set1);
			
			mysql_query("insert into `sms`.`round4` (`userid`) values ('{$row['id']}')");
			mysql_query("insert into `sms`.`round3` (`userid`) values ('{$row['id']}')");
			mysql_query("insert into `sms`.`round2` (`userid`) values ('{$row['id']}')");
			mysql_query("insert into `sms`.`round1` (`userid`) values ('{$row['id']}')");
			mysql_query("insert into `sms`.`portfolio` (`userid`) values ('{$row['id']}')");
			echo $row['id'];
		}else{
			echo "error in inserting data.<br/>".mysql_error()."<br/>";
		}
	}else{
		echo "improper input data.<br/>";
	}
}else{
	echo "Data not received.<br/>";
}
?>