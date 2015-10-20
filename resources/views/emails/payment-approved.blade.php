<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div><img src="http://breakingbind.com/img/breaking-bind-logo-black.png" alt="Breaking Bind" style="display: block; margin: 0 auto; width: 350px;"></div>
        <div><br></div>
        <div><br></div>
        <div>Hemos recibido el pago para las {{ $tickets }} entradas adjuntos en este correo.</div>
        <div>La información del usuario que realizó la compra:</div>
        <div>Nombre: {{ $name }}</div>
        <div>Email: {{ $email }}</div>
        <div>Teléfono: {{ $phone }}</div>
        <div>Número de Entradas: {{ $tickets }}</div>
        <div>Comentarios: {{ $comments }}</div>
        <div>Estado: {{ $status ? 'Pagado' : 'En espera del pago' }}</div>
        <div>Total a pagar: {{ $amountDue }} &euro;</div>
        <div>Forma de pago: {{ strcmp($payment, 'paypal') == 0 ? 'PayPal' : 'Transferencia Bancaria' }}</div>
    </body>
</html>