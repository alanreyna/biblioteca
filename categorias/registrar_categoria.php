<?php
    //print_r($_POST);
    if(empty($_POST["nombre_categoria"])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $nombre_categoria = $_POST["nombre_categoria"];
    
    $sentencia = $bd->prepare("INSERT INTO categorias(nombre_categoria) VALUES (?);");
    $resultado = $sentencia->execute([$nombre_categoria]);

    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
        //header('Location: categorias.php?mensaje=registrado');
    } else {
        echo json_encode(array("statusCode"=>201));
        exit();
    }
    
?>