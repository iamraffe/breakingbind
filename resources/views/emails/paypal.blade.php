<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://breakingbind.com/img/breaking-bind-logo-black.png" alt="Breaking Bind" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div><br></div>
        <div><br></div>
        <div><span class="font-weight: bold; color: #660087;"></span> {{ $name }}, muchas gracias por tu interés en la Fiesta de Halloween 2015 organizada por Breaking Bind. Hemos reservado {{ $tickets }} entradas a tu nombre. Podrás encontrar dichas entradas como archivos adjuntos en este correo electrónico.</div>
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
        <div><br></div>
        <div>Te esperamos!</div>
    </body>
</html>