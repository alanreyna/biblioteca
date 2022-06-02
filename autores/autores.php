<?php
include $_SERVER['DOCUMENT_ROOT']."/examen/template/header.php"; 
include_once $_SERVER['DOCUMENT_ROOT']."/examen/template/header.php";
?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <main>
        <div class="container">
            <div class="row g-5">
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Listado de Autores</h4>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Genero</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="table_autores"></tbody>
                        </table>
                    </div>
                </div>      
            </div>
        </div>
    </main>


<!-- Modal Add autores-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Autor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="fupForm" name="form1" method="post">
            <div class="mb-3">
                <label class="form-label">Nombre de Autor:</label>
                <input type="text" id="nombre_completo" class="form-control" require>
            </div>
            <div class="mb-3">
                <label class="form-label">Edad:</label>
                <input type="text" id="edad" class="form-control" require>
            </div>
            <div class="mb-3">
                <label class="form-label">Genero:</label>
                <select class="form-select" id="sexo" required="">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar_autor" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add autores-->

<!-- Modal edit autores-->
<div class="modal fade" id="exampleModal_edit" tabindex="-1" aria-labelledby="exampleModal_edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel_edit">Editar Autor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="edit_modal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_autor" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal edit autores-->

<script>
    $(document).ready(function() {

        $("#header_libros").removeClass("active");
        $("#header_categorias").removeClass("active");
        $("#header_autores").removeClass("active");
        $("#header_autores").addClass("active");



        //listado de autores
        $.ajax({
            url: "listado_autores.php",
            type: "POST",
            cache: false,
            success: function(data){
                $('#table_autores').html(data); 
            }
        });

        //agregar autor
        $('#guardar_autor').on('click', function() {
            var nombre_completo = $('#nombre_completo').val();
            var edad = $('#edad').val();
            var sexo = $('#sexo').val();
            $("#guardar_autor").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "registrar_autor.php",
                data: {
                    nombre_completo: nombre_completo,		
                    edad: edad,		
                    sexo: sexo		
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_autor").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Se a guardado el Autor con exito !'); 
                        $.ajax({
                            url: "listado_autores.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table_autores').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_autor").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#danger").show();
                        $('#danger').html('Hubo un problema al guardar los datos !'); 
                    }
                }
            });
        });


        //eliminar autor
        $(document).on('click', '.borrar_', function() {
                var del_id= $(this).attr('id');
                var $ele = $(this).parent().parent();
                
                $.ajax({
                    type:'POST',
                    url:'eliminar_autor.php',
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

        //editar autor
        $(document).on('click', '.editar', function() {
                $('#fupForm_edit').find('input:text').val('');
                var autor_id= $(this).attr('id');                
                $.ajax({
                    type:'POST',
                    url:'modal_edit.php',
                    data:{autor_id:autor_id},
                    cache: false,
                    success: function(data){
                        $('#edit_modal').html(data); 
                        $("#exampleModal_edit").modal("show");
                    }

                })
        });

        //edit autor post
        $('#editar_autor').on('click', function() {
            var nombre_completo = $('#nombre_completo_edit').val();
            var edad = $('#edad_edit').val();
            var sexo = $('#sexo_edit').val();
            var aut_id = $('#id_autor_edit').val();
            console.log(aut_id);
            $("#editar_autor").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "edit_autor.php",
                data: {
                    aut_id:aut_id,
                    nombre_completo: nombre_completo,		
                    edad: edad,		
                    sexo: sexo		
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        
                        $("#editar_autor").removeAttr("disabled");
                        $('#fupForm_edit').find('input:text').val('');
                        $('#nombre_completo_edit').val('');
                        $('#exampleModal_edit').modal('toggle');
                        $("#success").show();
                        $('#success').html('Se a edito el Autor con exito !'); 
                        $.ajax({
                            url: "listado_autores.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table_autores').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal_edit').modal('toggle');
                        $("#editar_autor").removeAttr("disabled");
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