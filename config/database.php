<?php
    session_start();
    $servername = "localhost";  
    $username = "root";        
    $password = "";             
    $dbname = "minimarket";        
    
    // Kết nối MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
?>