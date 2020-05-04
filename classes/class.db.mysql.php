<?php
include("config.php");

class db {
	var $connection = false;
	var $error = "";
	var $result = false;

	function db() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		if (!$this->connection) {
			$this->error = 'Error de conexión al server: ' .mysqli_connect_error();
			$this->connection = false;
		}
		
		return $this->connection;
	}
	
	function query($consulta) {
		$this->result = mysqli_query($this->connection, $consulta);
		
		if (!$this->result) {
			$this->error = 'Error en la Consulta: ' .mysqli_connect_error();
			return false;
		}
		
		return $this->result;
	}

	function close() {
		return mysqli_close($this->connection);
	}
		
	function onerow($result = false) {
		if (!$result) $result = $this->result;
		if ($result) return mysqli_fetch_assoc($result);
	}
}
?>