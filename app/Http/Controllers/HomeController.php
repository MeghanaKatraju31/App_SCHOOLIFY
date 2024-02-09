<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('basics.home');
    }
    public function about()
    {
        return view('basics.about');
    }
    public function contact()
    {
        return view('basics.contact');
    }
    public function services()
    {
        return view('basics.services');
    }
    public function submitContact(Request $request)
    {
        Contact::create([
            'inq_sender_name' => $request->name,
            'sender_email' => $request->email,
            'inq_sender_query' => $request->question,


        ]);

        return redirect()->back()->with('message',"Message sent successfully");
    }

}
