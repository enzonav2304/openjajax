<? require("../config/config.inc");

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

	function list_tables(){
		//voglio creare un'array di prova
		$result = mysql_list_tables($this->db_name);
		if(!$result) $mysql_response->show_errors();
		$num_rows = mysql_num_rows($result);//ecco il primo ciclo---------interessante
		$tablename_array = mysql_tablename($result, $i);
		$JSON = "[";
		for ($i = 0; $i < $num_rows; $i++){
			$JSON .= "{tablename:'".mysql_tablename($result, $i)."'},";
		}
		$JSON .= "]";
		echo str_replace("},]","}]", $JSON);//ho tolto l'ultima riga [i]
		//echo $JSON;
		//.mysql_tablename($result, $i).
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

	function get_descrizione($string_query){
		$query = mysql_query($string_query);
		while($row = mysql_fetch_object($query)){
			$record = $row->descrizione;
		}
		return $record;
	}
	
	function get_last_id($id){
		$string_query = "select id from libri_dett order by id desc limit 1";
		$query = mysql_query($string_query);
		while($row = mysql_fetch_object($query)){
			$id = $row->id;
		}
		return $id;
	}

	function number_of_rows($string_query){	
		$query = mysql_query($string_query);	
		$number_of_rows = @mysql_num_rows($query);	
		return $number_of_rows;
	}	
}



?>