<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\ParseContentRepository;
use App\Repositories\ParseRaffleRepository;
use App\Repositories\ParseTicketRepository;
use App\Repositories\ParseTicketsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Paypalpayment;

class TicketsPaymentController extends Controller
{

    private $tickets;

    private $contents;

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

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId = 'Ado1qKeiZ1O0WfKEVOEtL8-62O3ue1p5aY1ah9ymttQZY7T1FUgZh0g-N1MKz0BgMGP6qKVeU64BXL0m';
    private $_ClientSecret ='EBQLAqwZenfMRncbcknHNdIcJH18ETwmPI3Feo4B8oGgGZhSyLUgkg2Itg72-MQCT7GeJa96laHybjUa';

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */

    public function __construct(ParseTicketRepository $tickets, ParseContentRepository $contents)
    {

        $this->tickets = $tickets;
        
        $this->contents = $contents;

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        // Uncomment this step if you want to use per request
        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $ticket['amountDue'] =  intval($request->input('tickets')*55);

        $ticket['tickets'] =  intval($request->input('tickets'));

        $ticket['payment'] = floatval($request->input('payment'));

        $ticket['name'] = ucwords(strtolower($request->input('name')));

        $ticket['email'] = $request->input('email');

        $ticket['phone'] = $request->input('phone');

        $ticket['comments'] = empty($request->input('comments')) ? "El usuario no ha dejado ningún comentario." : $request->input('comments');

        $ticket['status'] = false;

        $ticketParseObject = $this->tickets->create($ticket);

        if(strcmp($request->input('payment'), 'paypal') == 0)
        {
            $request->session()->put('objectId', $ticketParseObject->getObjectId());

            $payer = Paypalpayment::Payer();
            $payer->setPaymentMethod("paypal");

            $tickets = Paypalpayment::item();
            $tickets->setName('Entrada Fiesta Halloween 2015')
                    ->setDescription('Entrada Fiesta Halloween 2015')
                    ->setCurrency('EUR')
                    ->setQuantity(intval($request->input('tickets')))
                    ->setPrice(55.00);

            $itemList = Paypalpayment::itemList();
            $itemList->setItems(array($tickets));

            $amount = Paypalpayment:: Amount();
            $amount->setCurrency("EUR")
                    ->setTotal(intval($request->input('tickets')*55));

            $transaction = Paypalpayment:: Transaction();
            $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription("Entrada Fiesta Halloween 2015")
                        ->setInvoiceNumber(uniqid());

            $baseUrl = $request->root();

            $redirectUrls = Paypalpayment:: RedirectUrls();

            $redirectUrls->setReturnUrl($baseUrl.'/tickets-payment/confirmpayment')
                        ->setCancelUrl($baseUrl.'/tickets-payment/cancelpayment');

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

            $email = $ticket['email'];
            $name = $ticket['name'];

            \Mail::send('emails.wire-transfer',
                $ticket,
               function($msg) use ($email, $name)
                {
                  $msg->to($email, $name);
                  $msg->from('info@breakingbind.com', 'Breaking Bind')->subject('¡Tu compra ha sido procesada correctamente!');
                });

            \Mail::send('emails.notification',
                $ticket,
               function($msg) use ($email, $name)
                {
                  $msg->from($email, $name);
                  $msg->to('info@breakingbind.com', 'Breaking Bind')->subject('Nueva compra de entradas para la fiesta de Halloween 2015 [TRANSFERENCIA BANCARIA]');
                });

            flash()->overlay('Tu compra ha sido procesada correctamente!', 'Por favor, revisa tu correo electronico '.$email.' y sigue las instrucciones para realizar el pago de las entradas.');

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

        // $this->tickets->update($objectId, ['status' => true, 'amountDue' => 0.00]);

        $ticketObject = $this->tickets->findBy('objectId', $objectId);

        $ticket['name'] = $ticketObject->name;
        $ticket['tickets'] = $ticketObject->tickets;
        $ticket['amountDue'] = $ticketObject->amountDue;
        $ticket['payment'] = $ticketObject->payment;
        $ticket['name'] = $ticketObject->name;
        $ticket['email'] = $ticketObject->email;
        $ticket['phone'] = $ticketObject->phone;
        $ticket['comments'] = $ticketObject->comments;
        $ticket['status'] = true;

        $name = $ticketObject->name;

        $email = $ticketObject->email;

        $tickets = $ticketObject->tickets;

        $ticketNumbers = [];

        for($i = 0; $i<$tickets; $i++){
          array_push($ticketNumbers, rand(10, 99).rand(100, 999));
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML(view('templates.ticket')->with('number', $ticketNumbers[$i]));
          $pdf->save('sold-tickets/Halloween2015'.$ticketNumbers[$i].'.pdf');
        }

        $this->tickets->update($objectId, ['status' => true, 'amountDue' => 0.00, 'ticketNumbers' => $ticketNumbers]);

        \Mail::send('emails.paypal',
            $ticket,
           function($msg) use ($email, $name, $tickets, $ticketNumbers)
            {
              $msg->to($email, $name);
              $msg->from('info@breakingbind.com', 'Breaking Bind')->subject('¡Tu compra ha sido procesada correctamente!');
              for($i = 0; $i<$tickets; $i++){
                $msg->attach('sold-tickets/Halloween2015'.$ticketNumbers[$i].'.pdf');
              }

            });

        \Mail::send('emails.payment-approved',
            $ticket,
           function($msg) use ($email, $name, $tickets, $ticketNumbers)
            {
              $msg->from($email, $name);
              $msg->to('info@breakingbind.com', 'Breaking Bind')->subject('Nueva compra de entradas a la fiesta de Halloween 2015 [PAYPAL]');
              for($i = 0; $i<$tickets; $i++){
                $msg->attach('sold-tickets/Halloween2015'.$ticketNumbers[$i].'.pdf');
              }
            });

        flash()->overlay('Tu compra ha sido procesada correctamente!', 'Muchas gracias por tu compra. Recuerda asistir a fiesta de Halloween el Sabado 31 de Octubre a partir de las 23:30h');

        return redirect('/');

    }

    public function getCancelpayment(Request $request)
    {

        $objectId = $request->session()->pull('objectId');

        $this->tickets->delete($objectId);

        flash()->error('El pago no ha sido completado', 'Ha cancelado el pago');

        return redirect('/');
    }


}
