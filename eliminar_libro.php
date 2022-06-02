<?php 
    if(!isset($_POST['lib_id'])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $codigo = $_POST['lib_id'];
    

    $sentencia = $bd->prepare("UPDATE libros SET activo = 0 WHERE id_libro = ?;");
    $resultado = $sentencia->execute([$codigo]);

    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
    } else {
        echo json_encode(array("statusCode"=>201));
    }
    
?>