<?php 
    if(!isset($_POST['cat_id'])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $codigo = $_POST['cat_id'];
    $nombre_categoria = $_POST['nombre_categoria'];
    //echo "UPDATE categorias SET nombre_categoria = '".$nombre_categoria."' WHERE id_categoria = ?;";
    $sentencia = $bd->prepare("UPDATE categorias SET nombre_categoria = ? WHERE id_categoria = ?;");
    $resultado = $sentencia->execute([$nombre_categoria, $codigo]);
    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
    } else {
        echo json_encode(array("statusCode"=>201));
    }
    
?>