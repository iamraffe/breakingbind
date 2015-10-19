   <div class="col-xs-12 col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Billetes vendidos</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="raffle-tickets" class="table table-bordered table-hover" data-order='[[2, "asc"]]'>
            <thead>
              <tr>
                <th>Ticket #</th>
                <th>Comprador</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
            @if(isset($allTickets) && ($allTickets->count() != 0))
              @foreach($allTickets as $ticket)
                @if($ticket->number != 2499)
                  <tr>
                    <td>{{ $ticket->number }}</td>
                    <td>{{ $ticket->buyer }}</td>
                    <td>{{ $ticket->getCreatedAt()->format('j/m H:i') }}</td>
                  </tr>
                @endif
              @endforeach
            @endif
            </tbody>
            <tfoot>
              <tr>
                <th>Ticket #</th>
                <th>Comprador</th>
                <th>Fecha</th>
              </tr>
            </tfoot>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->