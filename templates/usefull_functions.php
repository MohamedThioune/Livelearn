<?php

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    public $connexion;

    public function __construct($host,$dbname,$username,$password)
    {
        try
        {
            $this->host=$host;
            $this->dbname=$dbname;
            $this->username=$username;
            $this->password=$password;
            $this -> connexion = new mysqli($this->host,$this->username,$this->password,$this->dbname);
        }
        catch(Exception $e)
        {
            echo 'Erreur : '.$e->getMessage().'<br>';
        }
    }

    

    public function select ($table,$columns,$where)
    {
        try
        {
            $sql = "SELECT $columns FROM $table WHERE $where";
            $result = $this->connexion->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function isAlreadyExist($tableName,$title,$short_description,$type)
    {
        try
        {
            $sql = "SELECT * FROM $tableName WHERE titel = '$title' AND short_description = '$short_description' AND type = '$type'";
            $result = $this->connexion->query($sql);
            if ($result->num_rows==0)
                return false;
            return true;
        }
        catch(Exception $e)
        {
            echo 'Exception recieved: ', $e->getMessage(), "\n";
        }
    }
    public function insert ($tableName,$columns,$values)
    {
        try
        {
            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $result = $this->connexion->query($sql);
            return $result;

        }
        catch(Exception $e)
        {
            echo 'Exception recieved: ', $e->getMessage(), "\n";
        }
    }

    public function off ()
    {
        $this->connexion->close();
    }
}