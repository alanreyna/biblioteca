<?php 
    if(!isset($_POST['lib_id'])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $codigo = $_POST['lib_id'];
    $id_autor = $_POST['id_autor'];
    $id_categoria = $_POST['id_categoria'];
    $titulo = $_POST['titulo'];
    $portada = $_POST['portada'];
    $paginas = $_POST['paginas'];
    $sentencia = $bd->prepare("UPDATE libros SET id_autor = ?, id_categoria = ?, titulo = ?, portada = ?, paginas = ?  WHERE id_libro = ?;");
    $resultado = $sentencia->execute([$id_autor, $id_categoria, $titulo, $titulo, $paginas, $codigo]);
    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
    } else {
        echo json_encode(array("statusCode"=>201));
    }
    
?>