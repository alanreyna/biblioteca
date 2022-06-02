<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $libros_sql = $bd -> query("select * from libros where activo is true");
    $listado_libros = $libros_sql->fetchAll(PDO::FETCH_OBJ); 

    $categorias_sql = $bd -> query("select * from categorias where activo is true");
    $listado_categorias = $categorias_sql->fetchAll(PDO::FETCH_OBJ);

    $autores_sql = $bd -> query("select * from autores where activo is true");
    $listado_autores = $autores_sql->fetchAll(PDO::FETCH_OBJ); 

?>


    <?php 
    foreach($listado_libros as $libro){ 
        $autor_sql = $bd->prepare("SELECT nombre_completo from autores WHERE id_autor = ? LIMIT 1"); 
        $autor_sql->execute([$libro->id_autor]); 
        $autor = $autor_sql->fetch();

        $categoria_sql = $bd->prepare("SELECT nombre_categoria from categorias WHERE id_categoria = ? LIMIT 1"); 
        $categoria_sql->execute([$libro->id_categoria]); 
        $categoria = $categoria_sql->fetch();
        
?>
<tr>
    <td><?php echo $libro->titulo; ?></td>
    <td><?php echo $autor ["nombre_completo"]; ?></td>
    <td><?php echo $categoria ["nombre_categoria"]; ?></td>
    <td><?php echo $libro->paginas; ?></td>
    <td > 
        <a href="#" id=<?php echo $libro->id_libro; ?> class="editar"> 
            <i class="bi bi-pencil-square edit"></i>
        </a>  
        <a href="#" id=<?php echo $libro->id_libro; ?> class="borrar_"> 
            <i class="bi bi-trash-fill trash"></i>
        </a> 
        <a href="#" id=<?php echo $libro->id_libro; ?>  class="portada"> <i class="bi bi-book"></i> </a>
    </td>
</tr>
<?php 
    }
    exit();
?>
