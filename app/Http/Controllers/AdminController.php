<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\ParseContentRepository;
use App\Repositories\ParseTicketRepository;
use Illuminate\Http\Request;
use Parse\ParseObject;


class AdminController extends Controller
{

    private $tickets;

    private $contents;

    public function __construct(ParseTicketRepository $tickets, ParseContentRepository $contents)
    {

        $this->tickets = $tickets;

        $this->contents = $contents;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('admin.index');
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

            $excel->setTitle('Entradas Breaking Bind - Halloween 2015');

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
