<?php
    ini_set("display_errors",1);
    error_reporting(E_ALL);

    include('../../db.php');

    try{
        $pdo = new PDO("mysql:
        host=$db[host];
        port=$db[port];
        dbname=$db[dbname];
        charset=$db[charset];
        ", $db['username'], $db['password']);    

        $sql = 'INSERT INTO events (`title`, `year`, `month`, `date`, `start`, `end`, `description`)
                VALUES (:title, :year, :month, :date, :start, :end, :description)';
        $statement = $pdo -> prepare($sql);
        $statement -> bindValue(':title',$_POST['title'], PDO::PARAM_STR);
        $statement -> bindValue(':year',$_POST['year'], PDO::PARAM_INT);
        $statement -> bindValue(':month',$_POST['month'], PDO::PARAM_INT);
        $statement -> bindValue(':date',$_POST['date'], PDO::PARAM_INT);
        $statement -> bindValue(':start',$_POST['start'], PDO::PARAM_STR);
        $statement -> bindValue(':end',$_POST['end'], PDO::PARAM_STR);
        $statement -> bindValue(':description',$_POST['description'], PDO::PARAM_STR);
         
        if ($statement -> execute()) {
            
            $id = $pdo -> lastInsertId();

            $sql = 'SELECT id, title, start FROM events WHERE id=:id';
            $statement = $pdo -> prepare($sql);
            $statement -> bindValue(':id',$id,PDO::PARAM_INT);
            $statement -> execute();
            $event = $statement->fetch(PDO::FETCH_ASSOC);
            $event['start'] = substr($event['start'],0,5);
            echo json_encode($event);
        }else{
            echo ("<script>console.log(" . $statement -> errorInfo()[2] . ")</script>");
        }
        
    }catch(PDOException $e){
        echo "Database Connection Failed!";
        echo $e -> getMessage();
        exit;
    }