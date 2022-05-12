<!DOCTYPE html>
<html>
<head>
    <title>Pagos Booking Iwannatrip</title>

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

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">    

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="text-center" style="padding-top: 30px; padding-bottom: 30px;">
                Administración de Pagos Booking Iwannatrip
            </h1>
          
            <div class="table-responsive">
                <table id="pagos" class="table table-hover table-condensed">
                    <thead class="table-success">
                        <tr >
                            <th> ID </th>
                            <th> Calendario </th>
                            <th> Agrupamiento </th>
                            <th> Cliente </th>
                            <th> Pasajeros </th>                                                        
                            <th> Monto </th>
                            <th> Fecha Compra </th>
                            <th> Fecha Reserva </th>
                            <th> Recibo Banco </th>
                            <th> Fecha Recibo Banco </th>
                            <th> Pago Operador </th>
                            <th> Fecha Pago Operador </th>
                            <th> Observaciones </th>
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
                    <input type="hidden" name="reserva_id" id="reserva_id">

                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Recibo Banco</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="pgobanco" name="pgobanco" placeholder="Ingrese Recibo Banco" min="0" required="" value="0">
                        </div>
                    </div>                      
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Fecha Recibo Banco</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fechapagobanco" name="fechapagobanco" placeholder="Fecha Recibo Banco" required="">
                        </div>
                    </div>                      


                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Pago Operador</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="pagooperador" name="pagooperador" placeholder="Ingrese Pago Operador" min="0" required="" value="0">
                        </div>
                    </div>                      
                    
                    <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Fecha Pago Operador</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fechapagooperador" name="fechapagooperador" placeholder="Ingrese Fecha" required="">
                        </div>
                    </div>                                          

                   <div class="form-group">
                        <label class="control-label" style="text-align: left;padding-left: 15px;padding-bottom: 5px;">Observaciones</label>
                        <div class="col-sm-12">
                            <textarea name="observaciones" id="observaciones" cols="10" rows="10" class="form-control" style="resize: none;""></textarea>
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

        $('#pagos').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "/pagos/"+token,
                type: 'GET',
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },              
            columns: [
                {data: 'id', name: 'id'},
                {data: 'calendario', name: 'calendario'},  
                {data: 'agrupamiento', name: 'agrupamiento'},                          
                {data: 'nombre', name: 'nombre'},
                {data: 'pasajeros', name: 'pasajeros'},
                {data: 'monto', name: 'monto'},
                {data: 'fecharcompra', name: 'fecharcompra'},
                {data: 'fechareserva', name: 'fechareserva'},
                {data: 'pgobanco', name: 'pgobanco'},
                {data: 'fechapagobanco', name: 'fechapagobanco'},
                {data: 'pagooperador', name: 'pagooperador'},
                {data: 'fechapagooperador', name: 'fechapagooperador'},
                {data: 'observaciones', name: 'observaciones'},                
                {data: 'action', name: 'action', orderable: false, searchable: false},             
            ],         
            order: [[0, 'desc']]
        });

        /* When click edit coupon */
        $('body').on('click', '.edit-user', function () {
            var reserva_id = $(this).data('id');
            $.get('/pagos/edit/' + reserva_id, function (data) {

                var today;
                var today1;
                if(data[0].fechapagobanco === null || data[0].fechapagobanco === 'null'){
                    today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();
                    if(dd<10){dd='0'+dd} 
                    if(mm<10){mm='0'+mm} 
                    today = yyyy+'-'+mm+'-'+dd;  
                }else{
                    today = new Date(data[0].fechapagobanco);
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();
                    if(dd<10){dd='0'+dd} 
                    if(mm<10){mm='0'+mm} 
                    today = yyyy+'-'+mm+'-'+dd;                      
                }

                if(data[0].fechapagooperador === null || data[0].fechapagooperador === 'null'){
                    today1 = new Date();
                    var dd1 = today1.getDate();
                    var mm1 = today1.getMonth()+1; //January is 0!
                    var yyyy = today1.getFullYear();
                    if(dd<10){dd='0'+dd} 
                    if(mm1<10){mm1='0'+mm1} 
                    today1 = yyyy+'-'+mm1+'-'+dd;                      
                }else{
                    today1 = new Date(data[0].fechapagooperador);
                    var dd1 = today1.getDate();
                    var mm1 = today1.getMonth()+1; //January is 0!
                    var yyyy = today1.getFullYear();
                    if(dd1<10){dd1='0'+dd1} 
                    if(mm1<10){mm1='0'+mm1} 
                    today1 = yyyy+'-'+mm1+'-'+dd1;                      
                }                


                $('#userCrudModal').html("Editar");
                $('#btn-save').val("edit-user");
                $('#ajax-crud-modal').modal('show');
                $('#reserva_id').val(data[0].id);
                $('#pgobanco').val(Number(data[0].pgobanco));
                $('#fechapagobanco').val(today);
                $('#pagooperador').val(Number(data[0].pagooperador));
                $('#fechapagooperador').val(today1);                
                $('#observaciones').val(data[0].observaciones);
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
                        url: SITEURL + "/pagos/store",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#userForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Guardar Cambios');
                            var oTable = $('#pagos').dataTable();
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



