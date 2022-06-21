<?php
class DBConnection
{
  private string $servername;
  private string $username;
  private string $password;
  private string $dbanme;

  protected function connect()
  {
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbname = "sitelia";
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    return $conn;
  }
}