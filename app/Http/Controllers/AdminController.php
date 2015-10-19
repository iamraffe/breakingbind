<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Parse\ParseObject;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ParseRegistrationRepository;
use App\Repositories\ParseActivitiesRepository;
use App\Repositories\ParseRaffleRepository;
use App\Repositories\ParseTicketsRepository;

class AdminController extends Controller
{

    private $registrations;

    private $activities;

    private $raffle;

    private $tickets;

    public function __construct(ParseRegistrationRepository $parseRegistrationRepository, ParseActivitiesRepository $parseActivitiesRepository, ParseRaffleRepository $raffle, ParseTicketsRepository $tickets)
    {
        $this->registrations = $parseRegistrationRepository;

        $this->activities = $parseActivitiesRepository;

        $this->raffle = $raffle;

        $this->tickets = $tickets;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $allRegistrations = $this->registrations->all(['activity']);

        dd($allRegistrations->sortBy('createdAt.dates'));

        $allRaffle = $this->raffle->all();

        $allTickets = $this->tickets->all();

        $allTimeslots = $allRegistrations->groupBy('timeslot');

        $timeslots = ['10.00 AM - 11.00 AM', '11.00 AM - 12.00 PM', '12.00 PM - 01.00 PM', '01.00 PM - 02.00 PM', '06.00 PM - 07.00 PM'];

        foreach ($timeslots as $timeslot) {
            if(strcmp($timeslot, '06.00 PM - 07.00 PM') == 0){
                $count[$timeslot][0][0] = 0;
                $count[$timeslot][0][1] = 0;
                $count[$timeslot][1][0] = 0;
                $count[$timeslot][1][1] = 0;
            }
            else{
                $count[$timeslot][0] = 0;
                $count[$timeslot][1] = 0;
            }
        }

        $count['total'] = 0;

        foreach ($allTimeslots as $timeslot) {
            foreach($timeslot as $key => $registration){
                if(strcmp($registration->timeslot, '06.00 PM - 07.00 PM') == 0){
                    if(strcmp($registration->activity->name, 'Zumba Familiar') == 0){
                        if($registration->status){
                            $count[$registration->timeslot][0][0]+=($registration->adults + $registration->children);
                            $count['total']+=($registration->adults + $registration->children);
                        }
                        $count[$registration->timeslot][0][1]+=($registration->adults + $registration->children);
                    }
                    else{
                        if($registration->status){
                            $count[$registration->timeslot][1][0]+=($registration->adults + $registration->children);
                            $count['total']+=($registration->adults + $registration->children);
                        }
                        $count[$registration->timeslot][1][1]+=($registration->adults + $registration->children);
                    }
                }
                else{
                    if($registration->status){
                        $count[$registration->timeslot][0]+=($registration->adults + $registration->children);
                        $count['total']+=($registration->adults + $registration->children);
                    }
                    $count[$registration->timeslot][1]+=($registration->adults + $registration->children);
                }

            }
        }

        return view('admin.index')->with([
                        'allRegistrations' => $allRegistrations,
                        'allTimeslots' => $count,
                        'allRaffle' => $allRaffle,
                        'allTickets' => $allTickets,
                    ]);
    }

    public function pdfDownload()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('templates.pdf-download')->with('allRegistrations', $this->registrations->all(['activity'])))->setPaper('a4')->setOrientation('landscape');
        return $pdf->download(\Carbon\Carbon::now()->format('jFYhis').'.pdf', 1);
    }

    public function excelDownload()
    {
        return \Excel::create(\Carbon\Carbon::now()->format('jFYhis'), function($excel) {

            $excel->setTitle('Inscripciones Efecto Mariposa');

            $excel->setCreator('Fundaseth, S.L.')
                  ->setCompany('Fundaseth, S.L.');

            $excel->setDescription('Registro de las Inscripciones del acto de sensibilización "Súmate al Efecto Mariposa"');

            $excel->sheet('First sheet', function($sheet) {

                $allRegistrations = $this->registrations->all(['activity']);

                $allRegistrations = $allRegistrations->sortBy('timeslot')->sortBy('name');

                $sheet->loadView('templates.excel-download')->with('allRegistrations', $allRegistrations);

            });

        })->download('xlsx');
    }
}
