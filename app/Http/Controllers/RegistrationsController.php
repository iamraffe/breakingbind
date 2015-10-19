<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ParseRegistrationRepository;

class RegistrationsController extends Controller
{
    private $registrations;

    public function __construct(ParseRegistrationRepository $parseRegistrationRepository)
    {
        $this->registrations = $parseRegistrationRepository;
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

            $registration['amountDue'] = 0;

            $registration['status'] = true;

            $this->registrations->update($objectId, $registration);

            $registrationObject = $this->registrations->findBy('objectId', $objectId, ['*'],['activity']);

            $name = $registrationObject->name;

            $email = $registrationObject->email;

            $registration['adults'] = $registrationObject->adults;
            $registration['children'] = $registrationObject->children;
            $registration['timeslot'] = $registrationObject->timeslot;
            $registration['activity'] = $registrationObject->activity;
            $registration['payment'] = 'Transferencia Bancaria';
            $registration['name'] = $registrationObject->name;
            $registration['email'] = $registrationObject->email;
            $registration['phone'] = $registrationObject->phone;
            $registration['comments'] = $registrationObject->comments;

            \Mail::send('emails.inscription.paypal',
                $registration,
               function($msg) use ($email, $name)
                {
                  $msg->to($email, $name);
                  $msg->from('info@fundaseth.es', 'Fundaseth')->subject('¡La inscripción ha sido aprobada correctamente!');
                });

            /*\Mail::send('emails.notification',
                $registration,
               function($msg) use ($email, $name)
                {
                  $msg->from($email, $name);
                  $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Nuevo registro en la base de datos');
                });*/

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
            $this->registrations->delete($objectId);
            return response()->json(['Status' => 'OK', 'Message' => 'Registration deleted']);
        }
    }
}
