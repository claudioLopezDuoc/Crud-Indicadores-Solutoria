<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Librerias para los graficos - Charts --->
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/data.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="ajax">Indicadores UF Chile</a>
    </nav>
</header>

<body>
      
<div class="container">
    <h1> CRUD Indicadores Financieros - Solutoria </h1>

    @if(Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">   
                {{ Session::get('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div>
            <a class="btn btn-success" href="javascript:void(0)" id="createNewIndicador">  Nuevo Indicador</a>
            <a class="btn btn-primary" href="" id="btnDatos"> Importar Indicadores</a>
        </div>
        <br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                    <th>nombre</th>
                    <th>codigo</th>
                    <th>unidad</th>
                    <th>valor</th>
                    <th>fecha</th>
                    <th>tiempo</th>
                    <th>origen</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

        <div class="col">
            <div id="container" height:"400px" min-width: "310px"></div>
        </div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                

                <form id="indicadorForm" name="indicadorForm" class="form-horizontal">
                    
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label for="nombreIndicador">Nombre del Indicador:</label>
                        <input type="text" class="form-control" name="nombreIndicador" id="nombreIndicador" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="codigoIndicador">Codigo del Indicador:</label>
                        <select class="form-control" id="codigoIndicador" name="codigoIndicador" required>
                            <option selected>UF</option><br>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="unidadMedidaIndicador">Unidad de Medida del Indicador:</label>
                        <input type="text" class="form-control" name="unidadMedidaIndicador" id="unidadMedidaIndicador" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="valorIndicador">Valor del Indicador:</label>
                        <input type="text" step="any" class="form-control" name="valorIndicador" id="valorIndicador" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fechaIndicador">Fecha del Indicador:</label>
                        <input type="date"  class="form-control" name="fechaIndicador" id="fechaIndicador" value="" required>
                    </div>
                    
                    <div class="form-group">    
                        <label for="tiempoIndicador">Tiempo del Indicador:</label>
                        <input type="text" class="form-control" name="tiempoIndicador" id="tiempoIndicador" value="" required>
                    </div>
                        
                    <div class="form-group">
                        <label for="origenIndicador">Origen del Indicador:</label>
                        <input type="text" class="form-control" name="origenIndicador" id="origenIndicador" value="" required> 
                    </div>
        
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar Cambios</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        
      /*Pasamos por el  Header el CSRF Token*/ 
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
        
      /*Mostramos los datos en la tabla*/
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('ajax.index') }}",
          columns: [
              {data: 'nombreIndicador', name: 'nombreIndicador'},
              {data: 'codigoIndicador', name: 'codigoIndicador'},
              {data: 'unidadMedidaIndicador', name: 'unidadMedidaIndicador'},
              {data: 'valorIndicador', name: 'valorIndicador'},
              {data: 'fechaIndicador', name: 'fechaIndicador'},
              {data: 'tiempoIndicador', name: 'tiempoIndicador'},
              {data: 'origenIndicador', name: 'origenIndicador'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });


      /*BOTON PARA EXTRAER LA INFORMACION DE LA API*/  
      $('#btnDatos').click(function() {
            $.ajax({
                url: "ajax/datos",
                beforeSend: function(data) {
                    setTimeout(function() {
                        toastr.info('Es necesariio recargar la pagina',
                            'Indicadores', {
                                timeOut: 2000
                            });
                        location.reload();
                    });
                }
            });
        });
      
      /*Click en el boton New Indicador*/
      $('#createNewIndicador').click(function () {
          $('#saveBtn').val("create-indicador");
          $('#id').val('');
          $('#indicadorForm').trigger("reset");
          $('#modelHeading').html("Crear un Nuevo Indicador");
          $('#ajaxModel').modal('show');

      });
        
      /*Click en el boton Editar(function)*/
      $('body').on('click', '.editIndicador', function () {
        var id = $(this).data('id');
        $.get("{{ route('ajax.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Editar Indicador"); //Titulo
            $('#saveBtn').val("edit-indicador");
            $('#ajaxModel').modal('show');
            $('#id').val(data.id);
            $('#nombreIndicador').val(data.nombreIndicador);
            $('#codigoIndicador').val(data.codigoIndicador);
            $('#unidadMedidaIndicador').val(data.unidadMedidaIndicador);
            $('#valorIndicador').val(data.valorIndicador);
            $('#fechaIndicador').val(data.fechaIndicador);
            $('#tiempoIndicador').val(data.tiempoIndicador);
            $('#origenIndicador').val(data.origenIndicador);
        })
      });
        
      /*Codigo para crear un nuevo indicador*/
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Creando...');
        
          $.ajax({
            data: $('#indicadorForm').serialize(),
            url: "{{ route('ajax.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
         
                $('#indicadorForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
             
            },
            error: function (data) { //Error si no tienen campos al crear el formulario.
                console.log('Error:', data);
                $('#saveBtn').html('Error al Cargar los Datos');
            }
        });
      });
        
      /*Eliminar Producto*/
      $('body').on('click', '.deleteIndicador', function () {
       
          var id = $(this).data("id");
          confirm("Estas seguro de eliminar este dato?");
          
          $.ajax({
              type: "DELETE",
              url: "{{ route('ajax.store') }}"+'/'+id,
              success: function (data) {
                  table.draw();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });
         
    });
  </script>

  <!-- Script para la creacion de graficos --->
  <!---
  <script >
    var datas =  /*echo json_encode ($datas) *

    Highcharts.chart('chart-container',{
        title:{
            text: 'Uf Historica'
        },
        xAxias:{
            categories: ['Ene','Feb','Mzo','Abr','May','Jun','Jul','Agt','Sep','Oct','Nov','Dic',]
        },
        xAxias:{
            title: {
                text: 'Valor de la UF'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'Valor UF',
            data: datas
        }],
        responsive:{
            rules: [
                {
                    condition:{
                        maxwidth:500
                    },
                    chartOptions:{
                        legend:{
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
    }
                    }
                }
            ]
    }
    })

    


    </script>

-->
</body>
      

</html>