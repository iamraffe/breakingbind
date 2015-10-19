<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://sumatealefectomariposa.es/img/efecto-mariposa-logo.png" alt="Súmate al Efecto Mariposa" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div><span class="font-weight: bold; color: #660087;"></span> {{ $name }}, muchas gracias por “Sumarse al Efecto Mariposa”.</div>
        <div>Hemos bloqueado <strong>{{ $tickets }}</strong> papeletas para la rifa solidaria.</div>
        <div>Debe efectuar un pago por <strong>{{ $amountDue }} &euro;</strong> por transferencia o ingreso bancario a:</div>
        <div><br></div>
        <div><strong>Nombre beneficiario: Fundación Carlos Garrido Garrido</strong></div>
        <div><br></div>
        <div><strong>Entidad: La Caixa</strong></div>
        <div><br></div>
        <div><strong>IBAN: ES51 2100 1898 9002 0023 4934</strong></div>
        <div><br></div>
        <div><strong>Concepto: Papeletas Rifa Solidaria - {{ $name }}</strong></div>
        <div><br></div>
        <div>Por favor envíe al correo info@fundaseth.es el comprobante del pago correspondiente.</div>
        <div><br></div>
        <div><strong>Una vez transcurridas 72 horas, si no hemos recibido el citado justificante, el bloqueo de las papeletas quedará sin efecto y deberá realizar el trámite nuevamente.</strong></div>
        <div><br></div>
        <div><br></div>
        <div>Su solicitud ha sido procesada correctamente con los siguientes datos:<br></div>
        <div>Nombre: {{ $name }}</div>
        <div>Email: {{ $email }}</div>
        <div>Teléfono: {{ $phone }}</div>
        <div>Número de Tickets: {{ $tickets }}</div>
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