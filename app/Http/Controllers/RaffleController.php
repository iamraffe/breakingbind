<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ParseTicketsRepository;
use App\Repositories\ParseRaffleRepository;

class RaffleController extends Controller
{
    private $raffle;

    private $tickets;

    public function __construct(ParseRaffleRepository $parseRaffleRepository, ParseTicketsRepository $tickets)
    {
        $this->raffle = $parseRaffleRepository;

        $this->tickets = $tickets;
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

            /*$allTickets = $this->tickets->all();

            //dd($allTickets);

            $currentNumber = $allTickets->last()->number;

            dd($currentNumber);*/

            $raffle['amountDue'] = 0;

            $raffle['status'] = true;

            $this->raffle->update($objectId, $raffle);

            $raffleObject = $this->raffle->findBy('objectId', $objectId);

            $name = $raffleObject->name;

            $email = $raffleObject->email;

            $raffle['name'] = $raffleObject->name;

            $raffle['tickets'] = $raffleObject->tickets;

            $tickets = $raffleObject->tickets;

            $allTickets = $this->tickets->all();

            //dd($allTickets);

            $currentNumber = $allTickets->last()->number;

            //dd($currentNumber);

            for($i = 1; $i<=$tickets; $i++){

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML(view('templates.rifa.raffle-ticket')->with('number', $currentNumber+$i));
                $pdf->save('tickets/RifaSolidariaNo'.($currentNumber+$i).'.pdf');

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML(view('templates.rifa.raffle-talon')->with('number', $currentNumber+$i));
                $pdf->save('tickets/TalonRifaNo'.($currentNumber+$i).'.pdf');

                $this->tickets->create(['number' => ($currentNumber+$i), 'buyer' => $raffleObject->name]);
            }

            \Mail::queue('emails.raffle.paypal',
                $raffle,
               function($msg) use ($email, $name, $tickets, $currentNumber)
                {
                  $msg->to($email, $name);
                  $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡Su compra ha sido procesada correctamente!');
                  for($i = 1; $i<=$tickets; $i++){
                    $msg->attach('tickets/RifaSolidariaNo'.($currentNumber+$i).'.pdf');
                  }

                });

            \Mail::queue('emails.raffle.wire-transfer-ok',
                $raffle,
               function($msg) use ($email, $name, $tickets, $currentNumber)
                {
                  $msg->from($email, $name);
                  $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nueva pago de billetes de la Rifa Solidaria [TRANSFERENCIA BANCARIA]');
                  for($i = 1; $i<=$tickets; $i++){
                    $msg->attach('tickets/TalonRifaNo'.($currentNumber+$i).'.pdf');
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
            $this->raffle->delete($objectId);
            return response()->json(['Status' => 'OK', 'Message' => 'Raffle deleted']);
        }
    }

}
