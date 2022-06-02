<?php 
    include 'template/header.php';
    include_once "model/conexion.php";

    $categorias_sql = $bd -> query("select * from categorias where activo is true");
    $listado_categorias = $categorias_sql->fetchAll(PDO::FETCH_OBJ);

    $autores_sql = $bd -> query("select * from autores where activo is true");
    $listado_autores = $autores_sql->fetchAll(PDO::FETCH_OBJ); 

?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<main>
    <div class="container">
        <div class="row g-5">
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Listado de libros disponibles</h4>
                <div class="text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar Libro +</button>
                </div>
                <br>
                <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>
                <div class="alert alert-danger alert-dismissible" id="danger" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>

                <div class="col-sm-6">
                    <label for="buscador" class="form-label">Buscar por Categoria:</label> 
                    <input type="text" class="texto-gris form-control" id="buscador" value="Escribe la Categoria a buscar"/>
                </div>

                
                <div class="table-responsive" id="tablaLibros">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">No. de Paginas</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table_libros"></tbody>
                    </table>
                </div>
            </div>      
        </div>
    </div>
</main>

<!-- Modal Add book-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="fupForm" name="form1" method="post">
            <div class="mb-2">
                <label class="form-label">Titulo:</label>
                <input type="text" id="titulo" class="form-control" require>
            </div>
            <div class="mb-2">
                <label class="form-label">Autor:</label>
                <select class="form-select" id="id_autor" required="">
                <?php 
                    foreach($listado_autores as $autores){ 
                ?>
                    <option value="<?php echo $autores->id_autor; ?>" > <?php echo $autores->nombre_completo; ?> </option>
                <?php 
                    }
                ?>
              </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Categoria:</label>
                <select class="form-select" id="id_categoria" required="">
                <?php 
                    foreach($listado_categorias as $categoria){ 
                ?>
                    <option value="<?php echo $categoria->id_categoria; ?>" > <?php echo $categoria->nombre_categoria; ?> </option>
                <?php 
                    }
                ?>
              </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Numeto de Paginas:</label>
                <input type="text" id="paginas" class="form-control" require>
            </div>

            <div class="mb-2">
                <label class="form-label">URL Portada:</label>
                <input type="text" id="portada" class="form-control" require>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar_libro" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add book-->


<!-- Modal portada Libros-->
<div class="modal fade" id="exampleModal_portada" tabindex="-1" aria-labelledby="exampleModal_portada" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel_edit">Portada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="portada_modal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal portada Libros-->

<!-- Modal edit libro-->
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
        <button type="button" id="editar_libro" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal edit libro-->

<script>

//buscador Categoria libros
$('.texto-gris').each(function() {            
    var valorActual = $(this).val();
 
    $(this).focus(function(){                
        if( $(this).val() == valorActual ) {
            $(this).val('');
            $(this).removeClass('texto-gris');
        };
    });
 
    $(this).blur(function(){
        if( $(this).val() == '' ) {
            $(this).val(valorActual);
            $(this).addClass('texto-gris');
        };
    });
});


$("#buscador").keyup(function(){
    if( $(this).val() != ""){
        $("#tablaLibros tbody>tr").hide();
        $("#tablaLibros td:contiene-palabra('" + $(this).val() + "')").parent("tr").show();
    }else{
        $("#tablaLibros tbody>tr").show();
    }
});
 
$.extend($.expr[":"], {
    "contiene-palabra": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});
//buscador Categoria libros

    $(document).ready(function() {

        $("#header_libros").removeClass("active");
        $("#header_categorias").removeClass("active");
        $("#header_autores").removeClass("active");
        $("#header_libros").addClass("active");

        //listado de Libros
        $.ajax({
            url: "listado_libros.php",
            type: "POST",
            cache: false,
            success: function(data){
                $('#table_libros').html(data); 
            }
        });

        //agregar Libro
        $('#guardar_libro').on('click', function() {
            var id_autor = $('#id_autor').val();
            var id_categoria = $('#id_categoria').val();
            var titulo = $('#titulo').val();
            var portada = $('#portada').val();
            var paginas = $('#paginas').val();
            $("#guardar_libro").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "registrar_libro.php",
                data: {
                    id_autor: id_autor,			
                    titulo: titulo,			
                    id_categoria: id_categoria,			
                    portada: portada,			
                    paginas: paginas			
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_libro").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Se a guardado la Categoria con exito !'); 
                        $.ajax({
                            url: "listado_libros.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table_libros').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal').modal('toggle');
                        $("#guardar_libro").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#danger").show();
                        $('#danger').html('Hubo un problema al guardar los datos !'); 
                    }
                }
            });
        });


        //eliminar Libro
        $(document).on('click', '.borrar_', function() {
                var lib_id= $(this).attr('id');
                var $ele = $(this).parent().parent();
                
                $.ajax({
                    type:'POST',
                    url:'eliminar_libro.php',
                    data:{lib_id:lib_id},
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

        //editar libro
        $(document).on('click', '.editar', function() {
                var lib_id= $(this).attr('id');                
                $.ajax({
                    type:'POST',
                    url:'modal_edit.php',
                    data:{lib_id:lib_id},
                    cache: false,
                    success: function(data){
                        $('#edit_modal').html(data); 
                        $("#exampleModal_edit").modal("show");
                    }

                })
        });

        //Ver portada
        $(document).on('click', '.portada', function() {
                var lib_id= $(this).attr('id');
                $.ajax({
                    type:'POST',
                    url:'modal_portada.php',
                    data:{lib_id:lib_id},
                    cache: false,
                    success: function(data){
                        $('#portada_modal').html(data); 
                        $("#exampleModal_portada").modal("show");
                    }

                })
        });

        //edit libro post
        $('#editar_libro').on('click', function() {
            var id_autor = $('#id_autor_edit').val();
            var id_categoria = $('#id_categoria_edit').val();
            var titulo = $('#titulo_edit').val();
            var portada = $('#portada_edit').val();
            var paginas = $('#paginas_edit').val();
            var lib_id = $('#id_libro_edit').val();
            $("#editar_libro").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "edit_libro.php",
                data: {
                    lib_id:lib_id,
                    id_autor: id_autor,			
                    titulo: titulo,			
                    id_categoria: id_categoria,			
                    portada: portada,			
                    paginas: paginas			
                },
                cache: false,
                success:  function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#exampleModal_edit').modal('toggle');
                        $("#editar_libro").removeAttr("disabled");
                        $('#fupForm_edit').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Se a edito la Categoria con exito !'); 
                        $.ajax({
                            url: "listado_libros.php",
                            type: "GET",
                            cache: false,
                            success: function(data){
                                $('#table_libros').html(data); 
                            }
                        });						
                    }
                    else if(dataResult.statusCode==201){
                        $('#exampleModal_edit').modal('toggle');
                        $("#editar_libro").removeAttr("disabled");
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
<?php include 'template/footer.php' ?>