<?php 
    include('../db.php');

    $dbHost = $db['host'];
    $dbPort = $db['port'];
    $dbName = $db['dbname'];
    $dbUser = $db['username'];
    $dbPass = $db['password'];
    $dbChar = $db['charset'];

    echo "Test Database <br>";
    echo "Database info:<br>" . "<li>Host - $dbHost</li>" ."<li>Port - $dbPort</li>" . "<li>Name - $dbName</li>" ."<li>User - $dbUser</li>";

    //PDO Test
    try{
        echo 'Testing PDO<br>' . PHP_EOL;
        $pdo = new PDO("mysql:
        host=$dbHost;
        port=$dbPort;
        dbname=$dbName;
        charset=$dbChar;
        ", $dbUser, $dbPass); 
        echo 'PDO Connection Success!<br>' . PHP_EOL;
    }catch(Exception $e){
        echo 'PDO Connection failed: ' . $e->getMessage() ."<br>";
    }       

    // MySQLi Test
    try{
        echo 'Testing MySQLi<br>' . PHP_EOL;
        $mysqliConn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if (!$mysqliConn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
        echo "Host information: " . mysqli_get_host_info($mysqliConn) . PHP_EOL;

        mysqli_close($mysqliConn);
    }catch(Exception $e){
        echo $e -> getMessage();
    }

    
?> 