<? include_once('mysql-fix.php');
require("../config/config.inc");

class mysql_response{
	
	var $server;
	var $username;
	var $password;
	var $db_name;
	var $db_connect;
	var $server_status;
	var $my_database;
	var $string_query;	
	var $errors;
	
	function mysql_response($_server, $_user, $_password, $_db_name){
		$this->server = $_server;
		$this->username = $_user;
		$this->password = $_password;
		$this->db_name = $_db_name;
	}

	function database_connect(){
		$this->db_connect = mysql_connect($this->server, $this->username, $this->password);
		return $this->db_connect;
	}	
	
	function database_select(){
		$this->my_database = mysql_select_db($this->db_name, $this->db_connect) 
				or die ("<BR>Errore:". mysql_error());
		return $this->my_database;
	}

	function database_name(){
		return $this->db_name;
	}

	function show_errors(){
		$this->errors = mysql_errno($this->db_connect) .": ". mysql_error($this->db_connect)."\n";
		echo $this->errors;
	}	

	function return_table_values($string_query){
		$query = mysql_db_query($this->db_name, $string_query) or die ("<BR>Errore:". mysql_error());
		$number_of_rows = mysql_num_rows($query);//determino numero righe
		$JSON = "[";
		for ($i=0; $i < 1; $i++){
			$arr_num_fields[$i] = mysql_num_fields($query); //conto il numero campi
			for ($iii = 0; $iii < $number_of_rows; $iii++){
				//echo "tre - ";
				$JSON .= "{";
				$record = @mysql_fetch_row($query);
				for ($ii=0; $ii < $arr_num_fields[$i]; $ii++){
					$hash_field_names[$i][$ii] = mysql_field_name($query, $ii);
					//$JSON .= $hash_field_names[$i][$ii].":{".$hash_field_names[$i][$ii].":'".addslashes($record[$ii])."'},";
					$JSON .= $hash_field_names[$i][$ii].":'".addslashes($record[$ii])."',";				
				}
				$JSON .= "},";
			}				
		}
		$JSON .= "]";	
		echo str_replace(",},","},", $JSON);//ho tolto l'ultima riga [i]
	}
		
}



?>