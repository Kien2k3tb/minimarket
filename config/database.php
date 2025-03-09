<?php
    session_start();
    $servername = "localhost";  
    $username = "root";        
    $password = "";             
    $dbname = "minimarket";        
    
    // Kết nối MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);
    
       
?>