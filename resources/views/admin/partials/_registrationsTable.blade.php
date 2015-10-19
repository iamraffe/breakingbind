   <div class="col-xs-12 col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Inscripciones</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="registrations" class="table table-bordered table-hover" data-order='[[11, "asc"]]'>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Adultos</th>
                <th>Niños</th>
                <th>Turno</th>
                <th>Actividad</th>
                <th data-orderable="false">Comentarios</th>
                <th>Estado</th>
                <th>Pendiente de pago</th>
                <th>Total a pagar</th>
                <th>Fecha</th>
                <th data-orderable="false">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @if(isset($allRegistrations))
              @foreach($allRegistrations as $registration)
                  <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>
                        @for($i = 0; $i < $registration->adults; $i++)
                            <span class="fa fa-male"></span>
                        @endfor
                        ({{ $registration->adults }})
                    </td>
                    <td>
                        @for($i = 0; $i < $registration->children; $i++)
                            <span class="fa fa-child"></span>
                        @endfor
                        ({{ $registration->children }})
                    </td>
                    <td>{!! $registration->timeslot !!}</td>
                    <td>{!! $registration->activity->name !!}</td>
                    <td>{!! $registration->comments !!}</td>
                    <td>{!! $registration->status ? '<span class="label label-success">Pagado</span>' : '<span class="label label-danger">A espera del pago</span>' !!}</td>
                    <td>{!! $registration->amountDue !!} &euro;</td>
                    <td>{!! ($registration->adults * 3) +  $registration->children !!} &euro;</td>
                    <td>{{ $registration->getCreatedAt()->format('j/m H:i') }}</td>
                    <td>
                        <div class="text-right pull-right" style="width: 90px;">
                    @if(!$registration->status)
                            <form class="approve-registration" style="display:inline-block;">
                                <input type="hidden" name="_id" value="{{ $registration->getObjectId() }}">
                                <button class="btn btn-success btn-sm flat"  data-toggle="tooltip"  title="Aprobar">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                    @endif
                            <form class="delete-registration" style="display:inline-block;">
                                <input type="hidden" name="_id" value="{{ $registration->getObjectId() }}">
                                <button class="btn btn-danger btn-sm btn-delete flat"  data-toggle="tooltip"  title="Eliminar">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                  </tr>
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
                <th data-orderable="false">Comentarios</th>
                <th>Estado</th>
                <th>Pendiente de pago</th>
                <th>Total a pagar</th>
                <th>Fecha</th>
                <th data-orderable="false">Opciones</th>
              </tr>
            </tfoot>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->