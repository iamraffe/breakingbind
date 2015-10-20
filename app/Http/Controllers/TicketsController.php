<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\ParseContentRepository;
use App\Repositories\ParseRaffleRepository;
use App\Repositories\ParseTicketRepository;
use App\Repositories\ParseTicketsRepository;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    private $tickets;

    private $contents;

    public function __construct(ParseTicketRepository $tickets, ParseContentRepository $contents)
    {

        $this->tickets = $tickets;
        
        $this->contents = $contents;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $objectId)
    {
        if($request->ajax()){

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

            flash()->overlay('El usuario ha sido notificado del cambio de estado en su inscripción.', '¡La inscripción ha sido aprobada correctamente!');

            return response()->json(['Status' => 'OK', 'Message' => 'Registration approved & updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $objectId)
    {
        if($request->ajax()){
            $this->tickets->delete($objectId);
            return response()->json(['Status' => 'OK', 'Message' => 'Raffle deleted']);
        }
    }

}
