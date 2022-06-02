<?php
    if(empty($_POST["id_autor"])){
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    $id_autor = $_POST["id_autor"];
    $id_categoria = $_POST["id_categoria"];
    $titulo = $_POST["titulo"];
    $portada = $_POST["portada"];
    $paginas = $_POST["paginas"];
    
    $sentencia = $bd->prepare("INSERT INTO libros(id_autor, id_categoria, titulo, portada, paginas) VALUES (?, ?, ?, ?, ?);");
    $resultado = $sentencia->execute([$id_autor, $id_categoria, $titulo, $portada, $paginas]);

    if ($resultado === TRUE) {
        echo json_encode(array("statusCode"=>200));
        //header('Location: categorias.php?mensaje=registrado');
    } else {
        echo json_encode(array("statusCode"=>201));
        exit();
    }
    
?>