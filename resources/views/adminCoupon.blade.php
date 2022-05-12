<!DOCTYPE html>
<html>
<head>
    <title>Cupones Booking Iwannatrip</title>

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link  href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">  
    <link  href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css" rel="stylesheet">  
    <link  href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">  
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">    

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="text-center" style="padding-top: 30px; padding-bottom: 30px;">
                Administración de Cupones Booking Iwannatrip
            </h1>

            <br>
            <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-user">Nuevo Cupon</a>
            <br><br>            


            <div class="table-responsive">
                <table id="task" class="table table-hover table-condensed">
                    <thead class="table-success">
                        <tr >
                            <th> ID </th>
                            <th> Codigo </th>
                            <th> F. Exp </th>
                            <th> % </th>
                            <th> Estado </th>
                            <th> Reserva Origen </th>
                            <th> Reserva Destino </th>
                            <th> Min. Pas </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                </table>                
            </div>           
        </div>    
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1"  id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>                
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="cupon_id" id="cupon_id">

                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Codigo</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese Codigo" value="" maxlength="5" required="">
                        </div>
                    </div>                      
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Fecha de Expiracion</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fecha_expiracion" name="fecha_expiracion" placeholder="Ingrese Fecha" required="">
                        </div>
                    </div>                      
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">% Descuento</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese Descuento" min="1" required="">
                        </div>
                    </div>                     
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Estado</label>
                        <div class="col-sm-12">
                            <input type="checkbox" id="estado" name="estado" class="form-control">
                        </div>
                    </div>                      

                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Reserva Origen</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="id_res_origen" name="id_res_origen" placeholder="Ingrese Reserva Origen" min="0" value="0" required="">
                        </div>
                    </div>                                                                                 

                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Reserva Destino</label>
                        <div class="col-sm-12">
                                <input type="number" class="form-control" id="id_res_cons" name="id_res_cons" placeholder="Ingrese Reserva Destino" min="0" value="0" required="">
                        </div>
                    </div>                                                             
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Minimo de Pasajeros</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="min_pass" name="min_pass" placeholder="Ingrese Minimo de Pasajeros" min="1" required="">
                        </div>
                    </div>                                         

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Guardar Cambios</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    var SITEURL = '{{URL::to('')}}';
    var token = '{!! $token !!}';

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });          

        $('#task').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "/cupones/"+token,
                type: 'GET',
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },            
            columns: [
                {data: 'id', name: 'id'},
                {data: 'codigo', name: 'codigo'},
                {data: 'fecha_expiracion', name: 'fecha_expiracion'},
                {data: 'cantidad', name: 'cantidad'},
                {
                    data: "estado",
                    searchable: false,
                    sortable: false,
                    className: "text-center",
                    render: function ( data, type, row ) {
                        if(data === 1 || data === '1'){
                            return '<input type="checkbox" class="editor-active" checked disabled>';
                        }else{
                            return '<input type="checkbox" class="editor-active" disabled>';
                        }
                        return data;
                    }                     
                },               
                {data: 'id_res_origen', name: 'id_res_origen'},
                {data: 'id_res_cons', name: 'id_res_cons'},
                {data: 'min_pass', name: 'min_pass'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],         
            order: [[0, 'desc']]
        });

        /*  When user click add user button */
        $('#create-new-user').click(function () {
            $('#btn-save').val("create-user");
            $('#cupon_id').val('');
            $('#userForm').trigger("reset");
            $('#userCrudModal').html("Crear Nuevo Cupon");
            $('#ajax-crud-modal').modal('show');
        });   

        /* When click edit coupon */
        $('body').on('click', '.edit-user', function () {
            var cupon_id = $(this).data('id');
            $.get('/cupones/edit/' + cupon_id, function (data) {

                var today = new Date(data.fecha_expiracion);
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10){dd='0'+dd} 
                if(mm<10){mm='0'+mm} 
                today = yyyy+'-'+mm+'-'+dd;  

                $('#name-error').hide();
                $('#email-error').hide();
                $('#userCrudModal').html("Editar Cupon");
                $('#btn-save').val("edit-user");
                $('#ajax-crud-modal').modal('show');
                $('#cupon_id').val(data.id);
                $('#id').val(data.id);
                $('#codigo').val(data.codigo);
                $('#fecha_expiracion').val(today);
                $('#cantidad').val(data.cantidad);
                //$('#estado').val(data.estado);
                $("#estado").prop('checked', data.estado);
                $('#id_res_origen').val(data.id_res_origen);
                $('#id_res_cons').val(data.id_res_cons);
                $('#min_pass').val(data.min_pass);
            })
        }); 

        /* When click delete coupon */
        $('body').on('click', '#delete-user', function () {
     
            var cupones_id = $(this).data("id");
            var codigo = $(this).data("codigo");
            confirm("¿Seguro que quieres borrar el cupon " + codigo + " ?");
     
            $.ajax({
                type: "get",
                url: SITEURL + "/cupones/delete/"+cupones_id,
                success: function (data) {
                    var oTable = $('#task').dataTable(); 
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });  

        /* save or update coupon */
        if ($("#userForm").length > 0) {
            $("#userForm").validate({
        
                submitHandler: function(form) {
            
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Guardando...');
                    
                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: SITEURL + "/cupones/store",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                
                            console.log('exitoso guardar o editar: ', data);
                            $('#userForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Guardar Cambios');
                            var oTable = $('#task').dataTable();
                            oTable.fnDraw(false);
                            
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#btn-save').html('Guardar Cambios');
                        }
                    });
                    
                }
            })
        }                    
    });
</script>


</body>
</html>



