<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://sumatealefectomariposa.es/img/efecto-mariposa-logo.png" alt="Súmate al Efecto Mariposa" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div>Muchas gracias por inscribirse en Maratón Fitness y “Sumarse al Efecto Mariposa”</div>
        <div>Su solicitud ha sido procesada correctamente con los siguientes datos:<br></div>
        <div>Nombre: {{ $name }}</div>
        <div>Email: {{ $email }}</div>
        <div>Teléfono: {{ $phone }}</div>
        <div>Adultos: {{ $adults }}</div>
        <div>Niños: {{ $children }}</div>
        <div>Turno: {{ $timeslot }}</div>
        <div>Actividad: {{ $activity }}</div>
        <div>Comentarios: {{ $comments }}</div>
        <div>Estado: {{ $status }}</div>
        <div>Monto a pagar: {{ $amountDue }}</div>
        <div>Forma de pago: {{ strcmp($payment, 'paypal') == 0 ? 'PayPal' : 'Transferencia Bancaria' }}</div>
        <div><br></div>
        <div>Recuerde asistir el Sábado 26 de Septiembre desde las 10.00h hasta las 20.00h al GoFit de Montecarmelo.<br></div>
        <div>INFORMACIÓN SOBRE EL CENTRO</div>
        <div>Dirección: c/ Monasterio del Paular, 2</div>
        <div>Teléfono: 910 820 400</div>
    </body>
</html>