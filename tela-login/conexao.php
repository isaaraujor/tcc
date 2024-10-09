<?php
 $servername = "localhost"; 
 $username = "root"; 
 $password = ""; 
 $dbname = "contchamada"; 
 
 $con = new mysqli($servername, $username, $password, $dbname);
 
 if ($con->connect_error) {
     die("Conexão falhou: " . $con->connect_error);
 }
 ?>