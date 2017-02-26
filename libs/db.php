<?php

class db {
	private $connection;

	public function __construct($host = "localhost", $userName = "root", $password = "", $db = "st") {
        $this->connection = mysqli_connect($host, $userName, $password, $db);
	}

	public function query($query) {
	    $result = mysqli_query($this->connection, $query);

	    if (mysqli_errno($this->connection)) {
	        exit(mysqli_error($this->connection));
        }

        return strpos($query, "SELECT") !== false ? mysqli_fetch_all($result, MYSQLI_ASSOC) : $result;
    }

    public function insert_id() {
	    return mysqli_insert_id($this->connection);
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}