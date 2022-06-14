<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $id_reserva }}" data-original-title="Editar correo" class="edit btn btn-success edit-user-correo">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>        
</a>

<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $id }}" id="edit-{{ $id }}" data-original-title="Enviar Correo" class="edit btn btn-success edit-user">
    <i class="fa fa-envelope-o" aria-hidden="true"></i>
</a>

<a href="{{ URL::to('correosPDF/'.$id_reserva.'/es') }}"  data-toggle="tooltip"  data-id="{{ $id_reserva }}" data-original-title=" PDF ES" class="btn btn-success">
    ES
</a>

<a  href="{{ URL::to('correosPDF/'.$id_reserva.'/en') }}" data-toggle="tooltip"  data-id="{{ $id_reserva }}" data-original-title="PDF EN" class="btn btn-success">
    EN
</a>