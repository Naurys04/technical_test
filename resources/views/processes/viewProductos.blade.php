@extends('layouts.default')

@section('title')
{{__('Product Registration')}}
@endsection


@section('content')

<!-- product registration form -->
{{ Form::open(['route'=>'registro_productos','id' => 'frm3', 'class' => 'form' , 'autocomplete' => 'Off', 'enctype' => 'multipart/form-data']) }}
    <div class="row row lx-2">
        <div class="col-5">
            <label for="">{{__('Name')}}</label>
            <input class="form-control alingLeft solotexto" name="name" id="name" type="text">
        </div>
        <div class="col-5">
            <label for="">{{__('Price')}}</label>
            <input class="form-control alingLeft solotexto" name="price" id="price" type="text">
        </div>

    </div>

    {{ Form::hidden('hidden_id_productos', null, ['id'=> 'hidden_id_productos'])}}

    <div class="input-group mb-3 mt-3">
        <div class="col-6">
            {{ Form::button('Save', ['class' => 'btn btn-primary style', 'id' => 'save']) }}
            {{ Form::button('Cancel', ['class' => 'btn btn-danger style', 'id' => 'cancel']) }}
        </div>
    </div>
    <!-- end for poop form -->
        <div class="content-table">
            <div class="content-table-style">
                <table class="table table-striped table-hover" id="table1">
                </table>
            </div>
        </div>

    <!-- popup form to add comments to a product -->
    <div id="dialog-form" title="Add your comment">
        <fieldset>
            <div class="row row lx-2">
                <div class="row row lx-2">
                    <div class="col-6">
                        <label for="">{{__('Comment')}}</label>
                        <input class="form-control alingLeft " name="comment" id="comment" type="text">
                    </div>
                </div>
            </div>
            <div>
            {{ Form::hidden('hidden_products', null, ['id'=> 'hidden_products'])}}

                <div class="input-group mb-3 mt-3">
                    <div class="col-6">
                        {{ Form::button('Save', ['class' => 'btn btn-primary style', 'id' => 'save_custom']) }}
                        {{ Form::button('Cancel', ['class' => 'btn btn-danger style', 'id' => 'cancel_custom']) }}
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <!-- end for poop form -->
{{ Form::close() }}
<style type="text/css">
    .multiselect.dropdown-toggle {
        text-align: left;
    }
    .multiselect-container>li>a>label{
        padding: 5px;
        margin-bottom: 10px;
        text-align: center;
        font-weight: bold;
    }
</style>
<script type="text/javascript">

$(document).ready(function () {
    var empty = "{!! $records_productos !!}";
    empty = empty.replace(/\|/g,'"');
    empty = JSON.parse(empty);

    var elementos = [];
    for (var i = 0; i < empty.length; i++) {
        elementos.push(empty[i].Descripcion);
    }

    validaciones();
    fechaHeader();
    cargar_tabla(empty);

    $('#hidden_id_productos').val(null);


    $("#dialog-form").dialog({
      autoOpen: false,
      height: 400,
      width: 700,
      modal: true,
      close: function() {
        $('#codigo').focus();
        //allFields.removeClass( "ui-state-error" );
      }
    });

    $('#cancelar_custom').on('click', function(){
        $("#dialog-form").dialog('close');
    });


    $("#frm3").validate({
        rules: {
            name: {
                required: true
            },
            price:{
                required: true
            },
        },
        messages: {
            name :{
                required : 'Campo requerido'
            },
            price :{
                required : 'Campo requerido'
            },
        },
    });

    $('#save_custom').on('click', function(){
        $.post("products_comment",  {"id":$('#hidden_products').val(), "description":$('#comment').val()},function(data){
                $('#dialog-form').dialog('close');
                $('#comment').val('');

        },'json');
    });

    $('#cancelar_custom').on('click', function(){
        $('#dialog-form').dialog('close');
    });

    $('#save').on('click', function(){
        Swal.fire({
                title: 'Product Registration',
                text: '¿Are you sure you want to perform this operation?',
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si"
            }).then(function (result) {
            if (result.value) {
                $("form#frm3").submit();
                clean_fields();
            }
        });
    });

    $('#cancelar').on('click', function(){
        Swal.fire({
                title: 'Product Registration',
                text: '¿Are you sure you want to perform this operation?',
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si"
            }).then(function (result) {
            if (result.value) {
                clean_fields();
            }
        });
    });

    $('#name').on('blur', function(){
        $.post("buscar_codigo_producto",  {"id":$(this).val()},function(data){
            if(data.length != 0){
                toastr.error('Nombre Registrado', '');
                $('#name').val('');
            }
        },'json');
    });
    
});

function cargar_tabla(valor) {
    $("#table1").DataTable({
        processing: true,
        ordering: false,
        select: false,
        destroy:true,
        responsive: true,
        data: valor,
        "columnDefs": [
            {
              "defaultContent": "",
              "targets": '_all'
            }, 
            {
                "className": "dt-center",
                "targets"  : [0]
            },
        ],
        columns: [
            {title: 'id', data: 'id' , searchable: true, visible: false, className: 'text-center',defaultContent:null},           
            {title: 'Name', data: 'name' , searchable: true, visible: true, className: 'text-center',defaultContent:null},           
            {title: 'Price', data: 'price' , searchable: true, visible: true, className: 'text-center',defaultContent:null},                  
            {
                title: 'Acciones',
                data: null,
                searchable: false,
                className: "text-center",
                render: function (data, type, row, index) {
                    var btn = "";
                        btn += ' <a  href="javascript:editar('+data.id+');" class="btn btn-primary btn-sm btn-icon" >\n' +
                            '                <i class="fa fa-pencil-alt"></i>\n' +
                            '            </a>';
                        return btn;
                }
            },
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
        "autoWidth": true,
        "bLengthChange": false,
        "bFilter": false,
    })
}

function editar(id){
    $('#hidden_products').val(id);
    $("#dialog-form").dialog('open');
}

function clean_fields(){
    $('#name').val('');
    $('#price').val('');
    $('#hidden_id_productos').val(null);

}
</script>

@endsection
