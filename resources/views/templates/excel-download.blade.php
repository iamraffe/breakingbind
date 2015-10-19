<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table>
        <thead>
        <tr><th>INSCRIPCIONES</th></tr> 
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
                <td>{!! $registration->activity->name !!}</td>
                <td>{!! $registration->comments !!}</td>
                <td>{!! $registration->status ? '<span class="label label-success">Pagado</span>' : '<span class="label label-danger">A espera del pago</span>' !!}</td>
                <td>{!! $registration->amountDue !!} &euro;</td>
                <td>{{  \Carbon\Carbon::parse($registration->created_at)->format('j/m H:i') }}</td>
          @endforeach
        @endif
        </tbody>
    </table>

</html>