<?php

function getSQLServer() {
    
    $host = '127.0.0.1';
    $db   = 'workshop2'; 
    $user = 'root';              
    $pass = '1234567';                  
    $port = '3306';              

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // This will print the error if connection fails
        die("<h3>Database Connection Failed: " . $e->getMessage() . "</h3>");
    }
}

function getAfifDB() {
    
    $host = '10.241.214.216';  
    $db   = 'Internship_management';      
    $user = 'Irfan';           
    $pass = '12345';            
    $port = '1433';            

    try {
        $dsn = "odbc:Driver={ODBC Driver 17 for SQL Server};Server=$host,$port;Database=$db;";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Return null so we know it failed, but print the error for testing
        echo "<h3 style='color:red'>Remote Connection Failed: " . $e->getMessage() . "</h3>";
        return null;
    }
}

function getAdlinDB() {
    
    $host = '10.241.242.202';  
    $db   = 'student_db';      
    $user = 'root';           
    $pass = '1234';            
    $port = '3306';            
    

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Return null so we know it failed, but print the error for testing
        echo "<h3 style='color:red'>Remote Connection Failed: " . $e->getMessage() . "</h3>";
        return null;
    }
}

function getSyaDB() {
    
    $host = '10.241.195.132';  
    $db   = 'student_db';      
    $user = 'root';           
    $pass = '1234';            
    $port = '3306';            
    

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Return null so we know it failed, but print the error for testing
        echo "<h3 style='color:red'>Remote Connection Failed: " . $e->getMessage() . "</h3>";
        return null;
    }
}

function getBatrisyiaDB() {
    
    $host = '10.241.43.88';  
    $db   = 'student_db';      
    $user = 'root';           
    $pass = '1234';            
    $port = '3306';            
    

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Return null so we know it failed, but print the error for testing
        echo "<h3 style='color:red'>Remote Connection Failed: " . $e->getMessage() . "</h3>";
        return null;
    }
}

?>