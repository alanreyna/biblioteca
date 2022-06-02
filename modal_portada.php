<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $libro_sql = $bd->prepare("SELECT portada from libros WHERE id_libro = ? LIMIT 1"); 
    $libro_sql->execute([$_POST["lib_id"]]); 
    $libro = $libro_sql->fetch();
?>
<div class="mb-3">
    <img src="<?php echo $libro ["portada"]; ?> " class="rounded mx-auto d-block" alt="...">
</div>