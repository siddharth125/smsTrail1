<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
connect();
?>

<?php
	$query = "select * from `queries`
				order by `time` desc limit 30";
	
	$result_set = mysql_query($query);
	confirm_query($result_set);
	
	$final = array();
	while($row = mysql_fetch_array($result_set)){
		$arr = array(
		'userid'=>$row['userid'], 
		'company'=>$row['company'], 
		'count'=>$row['count']);
		if($row['bs'] == 0){
			//array_push($arr, "buy");
			$arr['type'] = "buy";
		}else{
			//array_push($arr, "sell");
			$arr['type'] = "sell";
		}
		
		array_push($final, $arr);
	}
	
	echo json_encode($final);
	
?>