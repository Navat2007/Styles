<?php        

$DB_SERVER = "localhost";
$DB_USER = "id82372760";
$DB_PASSWORD = "EVEonline2007";
$DB_DATABASE = "id82372760";

$conn = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(!$conn)
{
        die("Connection failed.". mysql_connect_error());
}