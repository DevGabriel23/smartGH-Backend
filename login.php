<?php
    include('db/db.php');

    header('Acccess-Control-Allow-Origin: *');

    if($_POST['METHOD'] == 'LOGIN'){
        unset($_POST['METHOD']);
        $userLog = $_POST['user'];
        $passLog = $_POST['pass'];
        $query="select * from users where user='$userLog'";
        $result = get($query);
        $hash = $result->fetch(PDO::FETCH_ASSOC)['pass'];
        if(password_verify($passLog,$hash)){
            echo "Login";
        }else{
            echo "Bad request";
        }
        header("HTTP/1.1 200 OK");
        exit();
    }

    if($_POST['METHOD'] == 'REGISTER'){
        unset($_POST['METHOD']);
        $userLog = $_POST['user'];
        $passLog = $_POST['pass'];
        $passStrong = password_hash($passLog,PASSWORD_DEFAULT);
        if((json_encode(get("select * from users where user='".$_POST['user']."'")->fetch(PDO::FETCH_ASSOC))) == "false"){
            $query="insert into users(user, pass) VALUES ('$userLog','$passStrong')";
            $queryAutoIncrement = "select MAX(id) as id from users";
            $result = post($query,$queryAutoIncrement);
            echo json_encode($result);
        }else{
            echo json_encode("Ya se ha registrado el usuario administrador");
        }
        header("HTTP/1.1 200 OK");
        exit();
    }
?>