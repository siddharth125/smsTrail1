<?php function connect(){
	$db=mysql_connect("127.0.0.1","root","");
	if(!$db){
		die("connection fail, error 101");
	}
	$db_c=mysql_select_db("sms",$db);
	if(!$db_c){
		die("connection fails, error 102");
	}
}
?>