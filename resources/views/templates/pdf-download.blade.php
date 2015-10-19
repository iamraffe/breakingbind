<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        *{
            font-family: sans-serif;
        }
        table {
          border-spacing: 0;
          border-collapse: collapse;
        }
        td,
        th {
          border: 1px solid silver;
        }
        th{
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            width: 10%;
            background-color: #660087;
            color: white;
            text-transform: uppercase;
        }
        td{
            font-size: 12px;
            text-align: left;
        }
        h3{
            text-transform: uppercase;
            text-align: center;
            font-size: 16px;

        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Inscripciones</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Adultos</th>
                        <th>Niños</th>
                        <th>Turno</th>
                        <th>Actividad</th>
                        <th>Comentarios</th>
                        <th>Estado</th>
                        <th>Monto a pagar</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(isset($allRegistrations))
                      @foreach($allRegistrations as $registration)
                          <tr>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            <td>{{ $registration->adults }}</td>
                            <td>{{ $registration->children }}</td>
                            <td>{!! $registration->timeslot !!}</td>
                            <td>{!! $registration->activity !!}</td>
                            <td>{!! $registration->comments !!}</td>
                            <td>{!! $registration->status ? '<span class="label label-success">Pagado</span>' : '<span class="label label-danger">A espera del pago</span>' !!}</td>
                            <td>{!! $registration->amountDue !!} &euro;</td>
                            <td>{{  \Carbon\Carbon::parse($registration->created_at)->format('j/m H:i') }}</td>
                      @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Adultos</th>
                        <th>Niños</th>
                        <th>Turno</th>
                        <th>Actividad</th>
                        <th>Comentarios</th>
                        <th>Estado</th>
                        <th>Monto a pagar</th>
                        <th>Fecha</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </div>

</body>
</html>