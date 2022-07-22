<?php
    include('db/db.php');

    header('Acccess-Control-Allow-Origin: *');

    $object = new DateTime();
    $object->setTimezone(new DateTimeZone('America/Mexico_City'));

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['id'])){
            $query="select * from datos where id=".$_GET['id'];
            $result = get($query);
            echo json_encode($result->fetch(PDO::FETCH_ASSOC));
        }else {
            $query="select * from datos";
            $result = get($query);
            echo json_encode($result->fetchAll());
        }
        header("HTTP/1.1 200 OK");
        exit();
    }

    if($_POST['METHOD'] == 'DATOS'){
        unset($_POST['METHOD']);
        $temp = $_POST['temp'];
        $hum = $_POST['hum'];
        $humS = $_POST['humS'];
        $nivelA = $_POST['nivelAgua'];
        $bomba = $_POST['bomba'];
        $fechaYHora = $object->format("Y-m-d H:i:s");

        $query="insert into datos(temperatura, humedad, humedadSuelo, nivelAgua, estadoBomba, datetime) VALUES ('$temp', '$hum', '$humS', '$nivelA', '$bomba', '$fechaYHora')";
        $queryAutoIncrement = "select MAX(id) as id from datos";
        $result = post($query,$queryAutoIncrement);

        echo json_encode($result);
        header("HTTP/1.1 200 OK");
        exit();
    }
    if($_POST['METHOD'] == 'RIEGO'){
        unset($_POST['METHOD']);
        $fecha = $object->format("Y-m-d");
        $hora = $object->format("H:i:s");
        $nivelA = $_POST['nivelAgua'];
        $query="insert into riego(fecha, hora, nivelAgua) VALUES ('$fecha', '$hora','$nivelA')";
        $queryAutoIncrement = "select MAX(id) as id from riego";
        $result = post($query,$queryAutoIncrement);
        echo json_encode($result);
        header("HTTP/1.1 200 OK");
        exit();
    }
?>