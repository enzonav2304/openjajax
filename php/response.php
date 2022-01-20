<? require("mysql.php");

/*---- Init SQL Class ----*/ 
$mysql_response = new mysql_response($db_server, $db_user, $db_password, $db_name);

$_db_connect = $mysql_response->database_connect();//mysql_connect
$_my_database = $mysql_response->database_select();//mysql_select_db
$_db_name = $mysql_response->database_name();

$table = $_GET['t'];	

switch($_GET['action']){	
	case "do_select":
		$string_query = "SELECT email from ".$table;
		$mysql_response->return_table_values($string_query);		
	break;
	case "do_table":
		$string_query = "SELECT * from ".$table;
		$mysql_response->return_table_values($string_query);		
	break;
	case "test_string":
		echo "Im a string. I was returned from Ajax, nice!";
	break;
		//break;
		/*
		$JSON = "[";
		$JSON .= "{tablename:'test'}";
		$JSON .= "]";
		//echo "Welcome in my new App!";
		echo $JSON;
		*/
		
}
?>

