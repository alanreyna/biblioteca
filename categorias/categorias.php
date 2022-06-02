<?php
include $_SERVER['DOCUMENT_ROOT']."/examen/template/header.php"; 
include_once $_SERVER['DOCUMENT_ROOT']."/examen/model/conexion.php";

$categorias_sql = $bd -> query("select * from categorias");
$listado_categorias = $categorias_sql->fetchAll(PDO::FETCH_OBJ);

//var_dump($listado_categorias);
?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>




<main>
    <div class="container">
        <div class="row g-5">
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Listado de Categorias</h4>
                <div class="text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar +</button>
                </div>
                <br>
                <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>
                <div class="alert alert-danger alert-dismissible" id="danger" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table_categorias">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table"></tbody>
                    </table>
                </div>
            </div>      
        </div>
    </div>
</main>

<!-- Modal Add categoria-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="fupForm" name="form1" method="post">
            <div class="mb-3">
                <label class="form-label">Nombre de Categoria:</label>
                <input type="text" id="nombre_categoria" class="form-control" require>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar_categoria" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add categoria-->


<!-- Modal edit categoria-->
<div class="modal fade" id="exampleModal_edit" tabindex="-1" aria-labelledby="exampleModal_edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel_edit">Editar Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="edit_modal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_categoria" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal edit categoria-->

<script>
    $(document).ready(function() {

        $("#header_libros").removeClass("active");
        $("#header_categorias").removeClass("active");
        $("#header_autores").removeClass("active");
        $("#header_categorias").addClass("active");



        //listado de categorias
        $.ajax({
            url: "listado_categorias.php",
            type: "POST",
            cache: false,
            success: function(data){
                $('#table').html(data); 
            }
        });

        //agregar categoria
        $('#guardar_categoria').on('click', function() {
            var nombre_categoria = $('#nombre_categoria').val();
            console.log(nombre_categoria);
            $("#guardar_categoria").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "registrar_categoria.php",
                data: {
                    nombre_categoria: nombre_categoria			
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_categoria").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Se a guardado la Categoria con exito !'); 
                        $.ajax({
                            url: "listado_categorias.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_categoria").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#danger").show();
                        $('#danger').html('Hubo un problema al guardar los datos !'); 
                    }
                }
            });
        });


        //eliminar categoria
        $(document).on('click', '.borrar_', function() {
                var del_id= $(this).attr('id');
                var $ele = $(this).parent().parent();
                
                $.ajax({
                    type:'POST',
                    url:'eliminar_categoria.php',
                    data:{del_id:del_id},
                    cache: false,
                    success: function(data){
                        var dataResult = JSON.parse(data);
                        if(dataResult.statusCode==200){
                            $ele.fadeOut().remove();
                            $("#success").show();
                            $('#success').html('Se a eliminado la Categoria con exito !');
                        }else{
                            $("#danger").show();
                            $('#danger').html('Hubo un problema al Eliminar el registro !'); 
                        }
                    }

                })
        });

        //editar categoria
        $(document).on('click', '.editar', function() {
                var cat_id= $(this).attr('id');
                var $ele = $(this).parent().parent();
                
                $.ajax({
                    type:'POST',
                    url:'modal_edit.php',
                    data:{cat_id:cat_id},
                    cache: false,
                    success: function(data){
                        $('#edit_modal').html(data); 
                        $("#exampleModal_edit").modal("show");
                    }

                })
        });

        //edit categoria post
        $('#editar_categoria').on('click', function() {
            var nombre_categoria = $('#nombre_categoria_edit').val();
            var cat_id = $('#id_categoria_edit').val();
            console.log(nombre_categoria);
            console.log(cat_id);
            $("#editar_categoria").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "edit_categoria.php",
                data: {
                    cat_id:cat_id,
                    nombre_categoria: nombre_categoria			
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#exampleModal_edit').modal('toggle');
                        $("#editar_categoria").removeAttr("disabled");
                        $('#fupForm_edit').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Se a edito la Categoria con exito !'); 
                        $.ajax({
                            url: "listado_categorias.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal_edit').modal('toggle');
                        $("#editar_categoria").removeAttr("disabled");
                        $('#fupForm_edit').find('input:text').val('');
                        $("#danger").show();
                        $('#danger').html('Hubo un problema al editar los datos !'); 
                    }
                }
            });
        });

    });
</script>
<style>
    .trash{
    display: inline-block;
    padding: 5px;
    color: red !important;
    }
    .edit{
    display: inline-block;
    color: blue !important;
    }
</style>

<?php include $_SERVER['DOCUMENT_ROOT']."/examen/template/footer.php" ?>