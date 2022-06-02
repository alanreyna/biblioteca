<?php 
    if(!isset($_POST['del_id'])){
        echo json_encode(array("statusCode"=>2011));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $codigo = $_POST['del_id'];
    

    $sentencia = $bd->prepare("UPDATE autores SET activo = 0 WHERE id_autor = ?;");
    $resultado = $sentencia->execute([$codigo]);

    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
    } else {
        echo json_encode(array("statusCode"=>2012));
    }
    
?>