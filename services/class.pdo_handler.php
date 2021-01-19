<?php
	class PdoHandler{
		private $host : string;
		private $username : string;
		private $password : string;
		private $database : string;
		private $prefix : string
		private function insert($conn, $sql, $params, $args){
			if( is_array ($args[0]) ){
				if(count($args[0]) != 0){
					$stmt = $conn->prepare($sql)
					foreach ($args as $key => $value) {
						foreach ($params as $key => $param) {
							$stmt->bindParam(":".$param, $$param);
							$$param = $value[$key];
						}
						$stmt=>execute();
					}
				} else {
					throw new Exception("args[". $key ."] is an empty array");
				}
			} else {
				throw new Exception("args[". $key ."] is not an array");
			}
		}
		private function connect($sql = null, ...$args){
			$output = [
				"status" => false,
				"message" => "",
				"result" => null
			];
			try{
				$conn = new PDO("mysql:host=".$this->host, $this->username, $this->password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if($sql === null){
					$conn->exec(
						"CREATE DATABASE " . $this->database . ";\n".
						"USE ".$this->database.";\n" .
						"CREATE TABLE ". $this->prefix ."roll_tables (
  							id INT(6) UNSIGNED AUTO_INCREMENT,
  							tablename VARCHAR(30) NOT NULL,
  							description TEXT,
  							PRIMARY KEY (id)
  						)\n" . 
  						"CREATE TABLE " . $this->prefix . "roll_table_options (
  							id INT(6) UNSIGNED AUTO_INCREMENT,
  							table_id INT(6) UNSIGNED NOT NULL,
  							option TEXT,
  							PRIMARY KEY (id),
  							FOREIGN KEY (table_id) REFERENCES ".$this->prefix ."roll_tables(id)
  						)\n" 
  					);
				$output["status"] = true;
				$output["message"] = "Database and tables created succesfully";
				}
				else if (false !== stripos($sql, ["CREATE", "DELETE", "ALTER"])){
					$conn->exec($sql);
				}
				else if(false !== stripos($sql, ["INSERT", "UPDATE"]) && count($args) != 0){
					$this->insert($conn, $sql, $args);	
				} else {
					$output["result"] = $conn->query($sql);
				}

			} catch(PDOException $e){
				$output["status"] = false;
				$output->message = $e->getMessage();
			} catch(Exception $e) {
				$output["status"] = false;
				$output["message"] = $e->getMessage();
			}
			return $output;		
		}

		function __construct($serverName = '127.0.0.1', $userName = 'root', $password = '', $db = 'tableStuckManager', $prefix = 'tsm'){
			$this->host = $serverName;
			$this->username = $userName;
			$this->password = $password;
			$this->database = $db;
			$this->prefix = '_'.$prefix;
		}
	}