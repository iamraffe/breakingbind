<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://breakingbind.com/img/breaking-bind-logo-black.png" alt="Breaking Bind" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div><br></div>
        <div><br></div>
        <div><span class="font-weight: bold; color: #660087;"></span> {{ $name }}, muchas gracias por tu interés en la Fiesta de Halloween 2015 organizada por Breaking Bind. Hemos bloqueado {{ $tickets }} entradas a tu nombre.</div>
        <div>Debes efectuar un pago por <strong>{{ $amountDue }} &euro;</strong> por transferencia o ingreso bancario a:</div>
        <div><br></div>
        <div><strong>Nombre beneficiario: Fundación Carlos Garrido Garrido</strong></div>
        <div><br></div>
        <div><strong>Entidad: La Caixa</strong></div>
        <div><br></div>
        <div><strong>IBAN: ES51 2100 1898 9002 0023 4934</strong></div>
        <div><br></div>
        <div><strong>Concepto: Fiesta de Halloween 2015 - {{ $name }}</strong></div>
        <div><br></div>
        <div>Por favor envía al correo info@breakingbind.com el comprobante del pago correspondiente.</div>
        <div><br></div>
        <div><strong>Una vez transcurridas 72 horas, si no hemos recibido el citado justificante, el bloqueo quedará sin efecto y deberás realizar el trámite nuevamente. En este caso, no podemos garantizar que haya alguna entrada disponible.</strong></div>
        <div><br></div>
        <div><br></div>
        <div>Tu solicitud ha sido procesada correctamente con los siguientes datos:<br></div>
        <div>Nombre: {{ $name }}</div>
        <div>Email: {{ $email }}</div>
        <div>Teléfono: {{ $phone }}</div>
        <div>Número de Entradas: {{ $tickets }}</div>
        <div>Comentarios: {{ $comments }}</div>
        <div>Estado: {{ $status ? 'Pagado' : 'En espera del pago' }}</div>
        <div>Total a pagar: {{ $amountDue }} &euro;</div>
        <div>Forma de pago: {{ strcmp($payment, 'paypal') == 0 ? 'PayPal' : 'Transferencia Bancaria' }}</div>
        <div><br></div>
        <div><br></div>
        <div><strong>No olvides asistir el Sábado 31 de Octubre a la Fiesta de Halloween, en la calle Gaztambide, 24. A partir de las 23:30h.</strong><br></div>
        <div><br></div>
        <div>Si tienes cualquier duda puedes contactarnos como respuesta a este correo o al teléfono: 913981628</div>
        <div><br></div>
        <div><strong>Te esperamos!</strong></div>
    </body>
</html>