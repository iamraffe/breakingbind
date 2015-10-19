<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paypalpayment;

use App\Repositories\ParseRegistrationRepository;
use App\Repositories\ParseActivitiesRepository;
use Carbon\Carbon;

class RegistrationPaymentController extends Controller
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

    private $registration;

    private $activities;

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

    public function __construct(ParseRegistrationRepository $registrations, ParseActivitiesRepository $parseActivitiesRepository)
    {

        $this->registration = $registrations;

        $this->activities = $parseActivitiesRepository;

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

        $amountDue = (floatval($request->input('adults')) * 3) + ($request->input('children') * 1);

        $registration['amountDue'] = $amountDue;

        $activity = $this->activities->findBy('code', intval($request->input('activity')));

        $registration['activity'] = $activity;

        $timeslots = [10 => '10.00 AM - 11.00 AM', 11 => '11.00 AM - 12.00 PM', 12 => '12.00 PM - 01.00 PM', 13 => '01.00 PM - 02.00 PM', 181 => '06.00 PM - 07.00 PM', 182 => '06.00 PM - 07.00 PM'];

        $registration['timeslot'] = $timeslots[intval($request->input('activity'))];

        $registration['payment'] = floatval($request->input('payment'));
        $registration['name'] = ucwords(strtolower($request->input('name')));
        $registration['email'] = $request->input('email');
        $registration['phone'] = $request->input('phone');
        $registration['comments'] = empty($request->input('comments')) ? "El usuario no ha dejado ningún comentario." : $request->input('comments');
        $registration['status'] = false;

        if(null !== $request->input('adults') && intval($request->input('adults')) != 0){
            $registration['adults'] = intval($request->input('adults'));
        }

        if(null !== $request->input('children') && intval($request->input('children')) != 0){
            $registration['children'] = intval($request->input('children'));
        }
        else{
            $registration['children'] = 0;
        }



        $registrationParseObject = $this->registration->create($registration);

        if(strcmp($request->input('payment'), 'paypal') == 0)
        {
            $request->session()->put('objectId', $registrationParseObject->getObjectId());

            $payer = Paypalpayment::Payer();
            $payer->setPaymentMethod("paypal");

            $adults = Paypalpayment::item();
            $adults->setName('Entrada adulto')
                    ->setDescription('Entrada adulto para participar en el evento "Súmate al Efecto Mariposa"')
                    ->setCurrency('EUR')
                    ->setQuantity(intval($request->input('adults')))
                    ->setPrice(3.00);

            $itemList = Paypalpayment::itemList();

            if(null !== $request->input('children') && intval($request->input('children')) != 0){
                $children = Paypalpayment::item();
                $children->setName('Entrada niño')
                        ->setDescription('Entrada niño para participar en el evento "Súmate al Efecto Mariposa"')
                        ->setCurrency('EUR')
                        ->setQuantity(intval($request->input('children')))
                        ->setPrice(1.00);

                $itemList->setItems(array($adults,$children));
            }
            else{
                $itemList->setItems(array($adults));
            }

            $amount = Paypalpayment:: Amount();
            $amount->setCurrency("EUR")
                    ->setTotal($amountDue);

            $transaction = Paypalpayment:: Transaction();
            $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription("Inscripción actividades en el evento \"Súmate al efecto mariposa\"")
                        ->setInvoiceNumber(uniqid());

            $baseUrl = $request->root();

            $redirectUrls = Paypalpayment:: RedirectUrls();

            $redirectUrls->setReturnUrl($baseUrl.'/registration-payment/confirmpayment')
                        ->setCancelUrl($baseUrl.'/registration-payment/cancelpayment');

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

            $email = $registration['email'];
            $name = $registration['name'];

            \Mail::send('emails.inscription.wire-transfer',
                $registration,
               function($msg) use ($email, $name)
                {
                  $msg->to($email, $name);
                  $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡Su inscripción ha sido procesada correctamente!');
                });

            \Mail::send('emails.notification',
                $registration,
               function($msg) use ($email, $name)
                {
                  $msg->from($email, $name);
                  $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nueva inscripción [TRANSFERENCIA BANCARIA]');
                });

            flash()->overlay('Por favor, revise su correo electrónico '.$email.' y siga las instrucciones para finalizar su inscripción.', '¡Su inscripción ha sido procesada correctamente!');

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

        $this->registration->update($objectId, ['status' => true, 'amountDue' => 0.00]);

        $registrationObject = $this->registration->findBy('objectId', $objectId, ['*'],['activity']);

        $name = $registrationObject->name;

        $email = $registrationObject->email;

        $registration['adults'] = $registrationObject->adults;
        $registration['children'] = $registrationObject->children;
        $registration['timeslot'] = $registrationObject->timeslot;
        $registration['activity'] = $registrationObject->activity;
        $registration['amountDue'] = $registrationObject->amountDue;
        $registration['payment'] = $registrationObject->payment;
        $registration['name'] = $registrationObject->name;
        $registration['email'] = $registrationObject->email;
        $registration['phone'] = $registrationObject->phone;
        $registration['comments'] = $registrationObject->comments;
        $registration['status'] = $registrationObject->status;

        \Mail::send('emails.inscription.paypal',
            $registration,
           function($msg) use ($email, $name)
            {
              $msg->to($email, $name);
              $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡Su inscripción ha sido procesada correctamente!');
            });

        \Mail::send('emails.notification',
            $registration,
           function($msg) use ($email, $name)
            {
              $msg->from($email, $name);
              $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nueva inscripción [PAYPAL]');
            });

        flash()->overlay('El pago se ha completado exitosamente.', '¡Su inscripción ha sido procesada correctamente!');

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
