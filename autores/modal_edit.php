<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";
    
    $categoria_sql = $bd -> query("select * from autores where id_autor = ".$_POST['autor_id']);
    $listado_autores = $categoria_sql->fetchAll(PDO::FETCH_OBJ);    
?>

<?php 
    foreach($listado_autores as $autor){ 
?>
<form id="fupForm_edit" name="form_edit" method="post">
    <div class="mb-3">
        <label class="form-label">Nombre de Autor:</label>
        <input type="text" id="nombre_completo_edit" class="form-control" value="<?php echo $autor->nombre_completo; ?>">
        <input type="hidden" id="id_autor_edit" class="form-control" value="<?php echo $autor->id_autor; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Edad:</label>
        <input type="text" id="edad_edit" class="form-control" require value="<?php echo $autor->edad; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Genero:</label>
        <select class="form-select" id="sexo_edit" value="<?php echo $autor->sexo ?>" required="">
        <option <?php if($autor->sexo == "M"){ echo 'selected';} ?> value="M">Masculino</option>
        <option <?php if($autor->sexo == "F"){ echo 'selected';} ?> value="F">Femenino</option>
        </select>
    </div>

</form>
<?php 
    }
    exit();
?>
