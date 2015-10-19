   <div class="col-xs-12 col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Rifa solidaria</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="raffle-data" class="table table-bordered table-hover" data-order='[[8, "asc"]]'>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Tickets</th>
                <th data-orderable="false">Comentarios</th>
                <th>Estado</th>
                <th>Pendiente de pago</th>
                <th>Total a pagar</th>
                <th>Fecha</th>
                <th data-orderable="false">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @if(isset($allRaffle) && ($allRaffle->count() != 0))
              @foreach($allRaffle as $raffle)
                  <tr>
                    <td>{{ $raffle->name }}</td>
                    <td>{{ $raffle->email }}</td>
                    <td>{{ $raffle->phone }}</td>
                    <td>{!! $raffle->tickets !!}</td>
                    <td>{!! $raffle->comments !!}</td>
                    <td>{!! $raffle->status ? '<span class="label label-success">Pagado</span>' : '<span class="label label-danger">A espera del pago</span>' !!}</td>
                    <td>{!! $raffle->amountDue !!} &euro;</td>
                    <td>{!! $raffle->tickets !!} &euro;</td>
                    <td>{{ $raffle->getCreatedAt()->format('j/m H:i') }}</td>
                    <td>
                        <div class="text-right pull-right" style="width: 90px;">
                    @if(!$raffle->status)
                            <form class="approve-raffle" style="display:inline-block;">
                                <input type="hidden" name="_id" value="{{ $raffle->getObjectId() }}">
                                <button class="btn btn-success btn-sm flat"  data-toggle="tooltip"  title="Aprobar">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                    @endif
                            <form class="delete-raffle" style="display:inline-block;">
                                <input type="hidden" name="_id" value="{{ $raffle->getObjectId() }}">
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
                <th>Tickets</th>
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