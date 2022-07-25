<?php
    include('db/db.php');

    header("Access-Control-Allow-Origin: *");

    if($_POST['METHOD'] == 'LOGIN'){
        unset($_POST['METHOD']);
        $userLog = $_POST['user'];
        $passLog = $_POST['pass'];
        $query="select * from users where user='$userLog'";
        $result = get($query);
        $data = $result->fetch(PDO::FETCH_ASSOC);   
        if(password_verify($passLog,$data['pass'])){
            echo json_encode($data);
        }else{
            echo json_encode(null);
        }
        header("HTTP/1.1 200 OK");
        exit();
    }

    if($_POST['METHOD'] == 'REGISTER'){
        unset($_POST['METHOD']);
        $userLog = $_POST['user'];
        $passLog = $_POST['pass'];
        $query = "select * from users";
        $result = get($query);
        $registros = $result->rowCount();
        $passStrong = password_hash($passLog,PASSWORD_DEFAULT);
        if($registros<1){
            $query="insert into users(user, pass) VALUES ('$userLog','$passStrong')";
            $queryAutoIncrement = "select MAX(id) as id from users";
            $result = post($query,$queryAutoIncrement);
            echo json_encode($result);
        }else{
            echo json_encode(null);
        }
        header("HTTP/1.1 200 OK");
        exit();
    }
?>