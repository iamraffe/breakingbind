<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paypalpayment;

use App\Repositories\ParseRaffleRepository;
use App\Repositories\ParseTicketsRepository;
use Carbon\Carbon;

class RafflePaymentController extends Controller
{
    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_paymentId;

    private $raffle;

    private $tickets;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId = 'AekrN1qv-Ln1YEGlIQ4y3ZgD5mbg7JmF7OEy0Cjm0enR5hr9xPIBnDtuoVOicNs9gjRWM-0KS9EcxYGd';
    private $_ClientSecret='EAmTtB2918ExSzXQlZhbm-RMiOuhgHkoa57_JTAgyBDTIvp-Gf_4GuNY4FRH-Q5f1bR7IrMbqLPtjwjZ';

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */

    public function __construct(ParseRaffleRepository $raffle, ParseTicketsRepository $tickets)
    {

        $this->raffle = $raffle;

        $this->tickets = $tickets;

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        // Uncomment this step if you want to use per request
        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'live',
            'service.EndPoint' => 'https://api.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

    public function index()
    {
        //return ("hello world");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        //$amountDue = intval($request->input('tickets'));

        $raffle['amountDue'] =  intval($request->input('tickets'));

        $raffle['tickets'] =  intval($request->input('tickets'));

        $raffle['payment'] = floatval($request->input('payment'));

        $raffle['name'] = ucwords(strtolower($request->input('name')));

        $raffle['email'] = $request->input('email');

        $raffle['phone'] = $request->input('phone');

        $raffle['comments'] = empty($request->input('comments')) ? "El usuario no ha dejado ningún comentario." : $request->input('comments');

        $raffle['status'] = false;

        $raffleParseObject = $this->raffle->create($raffle);

        if(strcmp($request->input('payment'), 'paypal') == 0)
        {
            $request->session()->put('objectId', $raffleParseObject->getObjectId());

            $payer = Paypalpayment::Payer();
            $payer->setPaymentMethod("paypal");

            $raffleTickets = Paypalpayment::item();
            $raffleTickets->setName('Billete Rifa Solidaria')
                    ->setDescription('Billete Rifa Solidaria para participar en el evento "Súmate al Efecto Mariposa"')
                    ->setCurrency('EUR')
                    ->setQuantity(intval($request->input('tickets')))
                    ->setPrice(1.00);

            $itemList = Paypalpayment::itemList();
            $itemList->setItems(array($raffleTickets));

            $amount = Paypalpayment:: Amount();
            $amount->setCurrency("EUR")
                    ->setTotal(intval($request->input('tickets')));

            $transaction = Paypalpayment:: Transaction();
            $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription("Billete Rifa Solidaria para participar en el evento \"Súmate al efecto mariposa\"")
                        ->setInvoiceNumber(uniqid());

            $baseUrl = $request->root();

            $redirectUrls = Paypalpayment:: RedirectUrls();

            $redirectUrls->setReturnUrl($baseUrl.'/raffle-payment/confirmpayment')
                        ->setCancelUrl($baseUrl.'/raffle-payment/cancelpayment');

            $payment = Paypalpayment:: Payment();
            $payment->setIntent("sale");
            $payment->setPayer($payer);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setTransactions(array($transaction));

            $response = $payment->create($this->_apiContext);

            //set the trasaction id , make sure $_paymentId var is set within your class
            $this->_paymentId = $response->id;

            //dump the repose data when create the payment
            $redirectUrl = $response->links[1]->href;

            //this is will take you to complete your payment on paypal
            //when you confirm your payment it will redirect you back to the rturned url set above
            //inmycase sitename/payment/confirmpayment this will execute the getConfirmpayment function bellow
            //the return url will content a PayerID var
            return redirect()->to($redirectUrl);
        }
        else{

            $email = $raffle['email'];
            $name = $raffle['name'];

            \Mail::send('emails.raffle.wire-transfer',
                $raffle,
               function($msg) use ($email, $name)
                {
                  $msg->to($email, $name);
                  $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡Su compra ha sido procesada correctamente!');
                });

            \Mail::send('emails.notification',
                $raffle,
               function($msg) use ($email, $name)
                {
                  $msg->from($email, $name);
                  $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nueva compra de billetes de la Rifa Solidaria [TRANSFERENCIA BANCARIA]');
                });

            flash()->overlay('Por favor, revise su correo electrónico '.$email.' y siga las instrucciones para finalizar su inscripción.', '¡Su compra ha sido procesada correctamente!');

            return redirect('/');
        }
    }

    public function getConfirmpayment(Request $request)
    {
        $payer_id = $request->input('PayerID');

        $payment = Paypalpayment::getById($request->input('paymentId'), $this->_apiContext);

        $paymentExecution = Paypalpayment::PaymentExecution();

        $paymentExecution->setPayerId( $payer_id );

        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        $objectId = $request->session()->pull('objectId');

        $this->raffle->update($objectId, ['status' => true, 'amountDue' => 0.00]);

        $raffleObject = $this->raffle->findBy('objectId', $objectId, ['*'], ['activity']);

        $name = $raffleObject->name;

        $email = $raffleObject->email;

        $raffle['name'] = $raffleObject->name;

        $raffle['tickets'] = $raffleObject->tickets;

        $tickets = $raffleObject->tickets;

        $allTickets = $this->tickets->all();

        $currentNumber = $allTickets->last()->number;

        $raffle['tickets'] = $raffleObject->tickets;
        $raffle['amountDue'] = $raffleObject->amountDue;
        $raffle['payment'] = $raffleObject->payment;
        $raffle['name'] = $raffleObject->name;
        $raffle['email'] = $raffleObject->email;
        $raffle['phone'] = $raffleObject->phone;
        $raffle['comments'] = $raffleObject->comments;
        $raffle['status'] = true;

        for($i = 1; $i<=$tickets; $i++){

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML(view('templates.rifa.raffle-ticket')->with('number', $currentNumber+$i));
            $pdf->save('tickets/RifaSolidariaNo'.($currentNumber+$i).'.pdf');

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML(view('templates.rifa.raffle-talon')->with('number', $currentNumber+$i));
            $pdf->save('tickets/TalonRifaNo'.($currentNumber+$i).'.pdf');

            $this->tickets->create(['number' => ($currentNumber+$i), 'buyer' => $raffleObject->name]);
        }

        \Mail::send('emails.raffle.paypal',
            $raffle,
           function($msg) use ($email, $name, $tickets, $currentNumber)
            {
              $msg->to($email, $name);
              $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡Su compra ha sido procesada correctamente!');
              for($i = 1; $i<=$tickets; $i++){
                $msg->attach('tickets/RifaSolidariaNo'.($currentNumber+$i).'.pdf');
              }

            });

        \Mail::send('emails.raffle.wire-transfer-ok',
            $raffle,
           function($msg) use ($email, $name, $tickets, $currentNumber)
            {
              $msg->from($email, $name);
              $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nueva compra de billetes de la Rifa Solidaria [PAYPAL]');
              for($i = 1; $i<=$tickets; $i++){
                $msg->attach('tickets/TalonRifaNo'.($currentNumber+$i).'.pdf');
              }
            });

        flash()->overlay('Muchas gracias por su compra. Recuerde asistir a la Rifa Solidaria el Sábado 26 de Septiembre a las 19.00 horas.', '¡Su compra ha sido procesada correctamente!');

        return redirect('/');

    }

    public function getCancelpayment(Request $request)
    {

        $objectId = $request->session()->pull('objectId');

        $this->registration->delete($objectId);

        flash()->overlay('Ha cancelado el pago.', 'Notificación sobre su pago.');

        return redirect('/');
    }


}
