<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
connect();
?>

<?php
if(!empty($_GET['round'])){
	$errors=array();
	//Valdation
	$required_fields=array('round');
	$errors = array_merge($errors, check_required_fields($required_fields));
	$round = trim(mysql_prep($_GET['round']));
	
	if(empty($errors)){
		$final = array();
		$query = "select * from `costtable`";
		$result_set = mysql_query($query);
		while($row = mysql_fetch_array($result_set)){
			$arr = array(
				'company'=>$row['company'], 
				'round'=>$row["round"."{$round}"]);
			if($round == 1){
				//array_push($arr,"0");
				$arr['change']="0";
				//$arr = array($row['company'], $row["round"."{$round}"], 0);
				//array_push($final, $arr);
			}else{
				$a = $row["round"."{$round}"];
				$round -= 1;
				$a -= $row["round"."{$round}"];
				//array_push($arr, (string)$a);
				$arr['change']=(string)$a;
				//$arr = array($row['company'], $row["round"."{$round}"], $row["round"."{$round}"] - $row["round"."{$round}"]);
				//array_push($final, $arr);
			}
			array_push($final, $arr);
		}
		echo json_encode($final);
	}else{
		echo "improper input data.<br/>";
	}
}else{
	echo "Data not received.<br/>";
}
?>