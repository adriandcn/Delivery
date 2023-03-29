<!DOCTYPE html>
<html>
<head>
    <title>Correo Booking Iwannatrip</title>

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
                Administración de Envío de Correo Booking Iwannatrip
            </h1>

            <div class="table-responsive">
                <table id="correos" class="table table-hover table-condensed">
                    <thead class="table-success">
                        <tr >
                            <th>ID Reserva</th>
                            <th>Enviado Operador</th>
                            <th>Confirmado Operador</th>
                            <th>Agrupamiento</th>
                            <th>Calendario</th>
                            <th>Cliente</th>
                            <th>Cedula</th>
                            <th>Email</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Notas</th>
                            <th width="100px"></th>
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
                    <input type="hidden" name="reserva_id" id="reserva_id">

                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Correo</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="c_email" name="c_email" placeholder="Ingrese Correo" required="">
                        </div>
                        </br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="c_envOper" name="c_envOper" placeholder="Enviado Operador" required="">
                        </div>
                        </br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="c_confOper" name="c_confOper" placeholder="Confirmado Operador" required="">
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

        $('#correos').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "/correos/"+token,
                type: 'GET',
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },            
            columns: [
                { data: 'id_reserva', name: 'id_reserva' },
                { data: 'c_envOper', name: 'c_envOper' },
                { data: 'c_confOper', name: 'c_confOper' },
                { data: 'agrupamiento', name: 'agrupamiento' },
                { data: 'calendario', name: 'calendario' },                
                { data: 'nombre', name: 'nombre' },
                { data: 'cedula', name: 'cedula' },
                { data: 'email', name: 'email' },
                { data: 'monto', name: 'monto' },
                { data: 'fechareserva', name: 'fechareserva' },
                { data: 'notes', name: 'notes' },
                
                { data: 'action', name: 'action', orderable: false, searchable: false }             
            ],         
            order: [[0, 'desc']]
        });

        /* When click send mail */
        $('body').on('click', '.edit-user', function () {
            var id = $(this).data('id');
            $('#edit-'+id).prepend('<i class="fa fa-repeat fa-spin"></i>');
            $('.edit-user').attr("disabled", false);
            $.get('edit/' + id , function (data) {
                $('#edit-'+id).find(':first-child').remove()
            })
        });        

        /* When click edit coupon */
        $('body').on('click', '.edit-user-correo', function () {
            var reserva_id = $(this).data('id');
            $.get('/correos/edit/' + reserva_id, function (data) {
                $('#userCrudModal').html("Editar Correo");
                $('#btn-save').val("edit-user-correo");
                $('#ajax-crud-modal').modal('show');
                $('#reserva_id').val(data.id);
                $('#c_email').val(data.c_email);
                $('#c_envOper').val(data.c_envOper);
                $('#c_confOper').val(data.c_confOper);
            })
        });  

        /* save or update reservation */
        if ($("#userForm").length > 0) {
            $("#userForm").validate({
        
                submitHandler: function(form) {
            
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Guardando...');
                    
                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: SITEURL + "/correos/store",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                
                            $('#userForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Guardar Cambios');
                            var oTable = $('#correos').dataTable();
                            oTable.fnDraw(false);
                            
                        },
                        error: function (data) {
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



