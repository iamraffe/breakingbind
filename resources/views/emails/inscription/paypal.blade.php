<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://sumatealefectomariposa.es/img/efecto-mariposa-logo.png" alt="Súmate al Efecto Mariposa" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div><span class="font-weight: bold; color: #660087;"></span> {{ $name }}, muchas gracias por inscribirse en el Maratón Fitness y “Sumarse al Efecto Mariposa”. Hemos reservado una plaza en <strong>{{ $activity->name }}</strong> en el horario <strong>{{ $timeslot }}</strong>.</div>
        <div><br></div>
        <div>Su solicitud ha sido procesada correctamente con los siguientes datos:<br></div>
        <div>Nombre: {{ $name }}</div>
        <div>Email: {{ $email }}</div>
        <div>Teléfono: {{ $phone }}</div>
        <div>Adultos: {{ $adults }}</div>
        <div>Niños: {{ $children }}</div>
        <div>Turno: {{ $timeslot }}</div>
        <div>Actividad: {{ $activity->name }}</div>
        <div>Comentarios: {{ $comments }}</div>
        <div>Estado: {{ $status ? 'Pagado' : 'En espera del pago' }}</div>
        <div>Total a pagar: {{ $amountDue }} &euro;</div>
        <div>Forma de pago: {{ strcmp($payment, 'paypal') == 0 ? 'PayPal' : 'Transferencia Bancaria' }}</div>
        <div><br></div>
        <div><br></div>
        <div><strong>Recuerde asistir el Sábado 26 de Septiembre desde las 10.00h hasta las 20.00h al GoFit de Montecarmelo.</strong><br></div>
        <div>INFORMACIÓN SOBRE EL CENTRO</div>
        <div>Dirección: c/ Monasterio del Paular, 2</div>
        <div>Teléfono: 910 820 400</div>
        <div><br></div>
        <div><br></div>
        <div>Un cordial saludo</div>
    </body>
</html>