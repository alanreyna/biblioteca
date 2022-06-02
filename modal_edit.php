<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $libros_sql = $bd -> query("select * from libros where id_libro = ".$_POST['lib_id']);
    $listado_libros = $libros_sql->fetchAll(PDO::FETCH_OBJ);    


    $categorias_sql = $bd -> query("select * from categorias where activo is true");
    $listado_categorias = $categorias_sql->fetchAll(PDO::FETCH_OBJ);

    $autores_sql = $bd -> query("select * from autores where activo is true");
    $listado_autores = $autores_sql->fetchAll(PDO::FETCH_OBJ); 
?>

<?php 
    foreach($listado_libros as $libro){ 
?>
<form id="fupForm_edit" name="form_edit" method="post">
    <div class="mb-2">
        <label class="form-label">Titulo:</label>
        <input type="text" id="titulo_edit" class="form-control" value="<?php echo $libro->titulo; ?>" require>
        <input type="hidden" id="id_libro_edit" class="form-control" value="<?php echo $libro->id_libro; ?>">
    </div>
    <div class="mb-2">
        <label class="form-label">Autor:</label>
        <select class="form-select" id="id_autor_edit" required="" value="<?php echo $libro->id_autor; ?>">
        <?php 
            foreach($listado_autores as $autores){ 
        ?>
            <option <?php if($libro->id_autor === $autores->id_autor){ echo 'selected';} ?> value="<?php echo $autores->id_autor; ?>" > <?php echo $autores->nombre_completo; ?> </option>
        <?php 
            }
        ?>
        </select>
    </div>
    <div class="mb-2">
        <label class="form-label">Categoria:</label>
        <select class="form-select" id="id_categoria_edit" value="<?php echo $libro->id_categoria; ?>" required="">
        <?php 
            foreach($listado_categorias as $categoria){ 
        ?>
            <option  <?php if($libro->id_categoria === $categoria->id_categoria){ echo 'selected';} ?> value="<?php echo $categoria->id_categoria; ?>" > <?php echo $categoria->nombre_categoria; ?> </option>
        <?php 
            }
        ?>
        </select>
    </div>
    <div class="mb-2">
        <label class="form-label">Numeto de Paginas:</label>
        <input type="text" id="paginas_edit" class="form-control" value="<?php echo $libro->paginas; ?>" require>
    </div>

    <div class="mb-2">
        <label class="form-label">URL Portada:</label>
        <input type="text" id="portada_edit" class="form-control" value="<?php echo $libro->portada; ?>">
    </div>
</form>
<?php 
    }
    exit();
?>
