<?php
//input:- userid,company,count,round
//output:- 0- query not executed due to lack of balance
//1-  query executed
//anything else:- error due to improper input or some other cause
?>

<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
connect();
?>

<?php
if(!empty($_GET['userid'])||!empty($_GET['company'])||!empty($_GET['count'])||!empty($_GET['round'])){
	$errors=array();
	//Valdation
	$required_fields=array('userid','company','count','round');
	$errors = array_merge($errors, check_required_fields($required_fields));
	
	$userid = trim(mysql_prep($_GET['userid']));
	$company = trim(mysql_prep($_GET['company']));
	$count = trim(mysql_prep($_GET['count']));
	$round = trim(mysql_prep($_GET['round']));
	
	if(empty($errors)){
		$query = "SELECT * FROM `costtable` WHERE `company` LIKE '{$company}'";
		$result_set = mysql_query($query);
		confirm_query($result_set);
		$row = mysql_fetch_array($result_set);
		
		$cost = $count*$row['round'."{$round}"];
		
		$query = "SELECT * FROM  `portfolio` WHERE  `userid` = {$userid}";
		$result_set = mysql_query($query);
		confirm_query($result_set);
		$row1 = mysql_fetch_array($result_set);
		
		if(!($row1['value'] >= $cost)){
			// echo 0;
			exit;
		}
		
		for($i=$round;$i<5;$i+=1){
			${"query".$i} = "update `round{$i}` set `{$company}` = `{$company}`+{$count}  where `userid` = {$userid}";
			//${"result_set".$i} = mysql_query(${"query".$i});
			$resultSet = mysql_query(${"query".$i});
			confirm_query($resultSet);
			//confirm_query(${"result_set".$i});
			//${"row".$i} = mysql_fetch_array(${"result_set".$i});
			//${"row".$i} = mysql_fetch_array($resultSet);
			//echo ${"row".$i}["{$company}"]."<br/>";
		}
		
		$query = "update `portfolio` set `value` = `value` - {$cost} where `userid` = {$userid}";
		$result_set = mysql_query($query);
		confirm_query($result_set);
		
		$query = "INSERT INTO `sms`.`queries` (`userid`, `company`, `count`, `bs`, `time`) VALUES ({$userid}, {$company}, {$count}, 0, CURRENT_TIMESTAMP)";
		$result = mysql_query($query);
		confirm_query($result);
		
		echo 1;
		exit;
	}else{
		echo "improper input data.<br/>";
	}
}else{
	echo "Data not received.<br/>";
}
?>