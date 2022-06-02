<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $categorias_sql = $bd -> query("select * from categorias where activo is true");
    $listado_categorias = $categorias_sql->fetchAll(PDO::FETCH_OBJ);    
?>

    <?php 
    foreach($listado_categorias as $categoria){ 
?>
<tr>
    <td><?php echo $categoria->nombre_categoria; ?></td>
    <td > 
        <a href="#" id=<?php echo $categoria->id_categoria; ?> class="editar"> 
            <i class="bi bi-pencil-square edit"></i>
        </a>  
        <a href="#" id=<?php echo $categoria->id_categoria; ?> class="borrar_"> 
            <i class="bi bi-trash-fill trash"></i>
        </a> 
    </td>
</tr>
<?php 
    }
    exit();
?>
