<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $autores_sql = $bd -> query("select * from autores where activo is true");
    $listado_autores = $autores_sql->fetchAll(PDO::FETCH_OBJ);    
?>

    <?php 
    foreach($listado_autores as $autores){ 
        $genero = $autores->sexo =='M' ? 'Masculino' : 'Femenino';
?>
<tr>
    <td><?php echo $autores->nombre_completo; ?></td>
    <td><?php echo $autores->edad; ?></td>
    <td><?php echo $genero; ?></td>
    <td > 
        <a href="#" id=<?php echo $autores->id_autor; ?> class="editar"> 
            <i class="bi bi-pencil-square edit"></i>
        </a>  
        <a href="#" id=<?php echo $autores->id_autor; ?> class="borrar_"> 
            <i class="bi bi-trash-fill trash"></i>
        </a> 
    </td>
</tr>
<?php 
    }
    exit();
?>
