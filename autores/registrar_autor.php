<?php
    //print_r($_POST);
    if(empty($_POST["nombre_completo"])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $nombre_completo = $_POST["nombre_completo"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];
    
    $sentencia = $bd->prepare("INSERT INTO autores(nombre_completo, edad, sexo) VALUES (?, ?, ?);");
    $resultado = $sentencia->execute([$nombre_completo, $edad, $sexo]);

    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
        //header('Location: categorias.php?mensaje=registrado');
    } else {
        echo json_encode(array("statusCode"=>201));
        exit();
    }
    
?>