<?php
final class context
{
    var $db_host = "localhost";
    var $db_name = "flightcompany";
    var $db_user = "root";
    var $db_password = "12345678";
    var $connection;
    function connect()
    {

        try {
            $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
            if ($this->connection->connect_error) {
                throw new Exception("Error Processing Request", 1);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function getConnection()
    {
        if ($this->connection)
            return $this->connection;
        else
            return null;
    }
    function disconnect()
    {
        try {
            $this->connection->close();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}


?>