<?php 
    if(!isset($_POST['aut_id'])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $codigo = $_POST['aut_id'];
    $nombre_completo = $_POST['nombre_completo'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $sentencia = $bd->prepare("UPDATE autores SET nombre_completo = ?, edad = ?, sexo = ?  WHERE id_autor = ?;");
    $resultado = $sentencia->execute([$nombre_completo, $edad, $sexo, $codigo]);
    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
    } else {
        echo json_encode(array("statusCode"=>201));
    }
    
?>