<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return Response
     */
    public function index()
    {
        return view('pages.index');
    }

    /**
     * Send contact email.
     *
     * @return Response
     */
    public function contact(Request $request)
    {
        $email = $request->input("email");
        $name = $request->input("nombre");

        \Mail::queue('emails.contact',
                    $request->all(),
                   function($msg) use ($email, $name)
                    {
                      $msg->from($email, $name);
                      $msg->to('info@fundaseth.es', 'Fundaseth')->subject('Contacto [WEB]');
                    });
        return array('status' => 'OK', 'code' => 200, 'message' => 'Email enviado.');
    }

    /**
     * Display the terms and conditions page.
     *
     * @return Response
     */
    public function termsAndConditions()
    {
        return view('pages.terms-and-conditions');
    }


}
