<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $categoria_sql = $bd -> query("select * from categorias where id_categoria = ".$_POST['cat_id']);
    $listado_categoria = $categoria_sql->fetchAll(PDO::FETCH_OBJ);    
?>

<?php 
    foreach($listado_categoria as $categoria){ 
?>
<form id="fupForm_edit" name="form_edit" method="post">
    <div class="mb-3">
        <label class="form-label">Nombre de Categoria:</label>
        <input type="text" id="nombre_categoria_edit" class="form-control" value="<?php echo $categoria->nombre_categoria; ?>" require>
        <input type="hidden" id="id_categoria_edit" class="form-control" value="<?php echo $categoria->id_categoria; ?>">
    </div>
</form>
<?php 
    }
    exit();
?>
