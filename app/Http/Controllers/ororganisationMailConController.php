<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\organisation_config_mail;

class ororganisationMailConController extends Controller
{
    public function index(){
        $id = Auth::guard('superadmin')->user()->id;
        // $mailDatas = organisation_config_mail::where('organisation_id',$id)->get();

        $mailDatas = DB::table('organisation_config_mails')
               ->where('organisation_id', $id)
               ->get();
        return view('superadmin_view.create_mail_config',compact('mailDatas'));
    }

    public function insertMailConfig(Request $request){
        $data = $request->validate([
            'organisation_id' => 'required',
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_PORT' => 'required',
            'MAIL_USERNAME' => 'required',
            'MAIL_PASSWORD' => 'required',
            'MAIL_ENCRYPTION' => 'required',
            'MAIL_FROM_ADDRESS' => 'required',
            'MAIL_FROM_NAME' => 'required',
        ]);


        $organisationConfigMail =  DB::table('organisation_config_mails')->insert([
            'MAIL_MAILER' => $data['MAIL_MAILER'],
            'MAIL_HOST' => $data['MAIL_HOST'],
            'MAIL_PORT' => $data['MAIL_PORT'],
            'MAIL_USERNAME' => $data['MAIL_USERNAME'],
            'MAIL_PASSWORD' => $data['MAIL_PASSWORD'],
            'MAIL_ENCRYPTION' => $data['MAIL_ENCRYPTION'],
            'MAIL_FROM_ADDRESS' => $data['MAIL_FROM_ADDRESS'],
            'MAIL_FROM_NAME' => $data['MAIL_FROM_NAME'],
            'organisation_id' => $data['organisation_id'],
            'created_at' => NOW(),
            'updated_at' => NOW(),
             ]);

             if($organisationConfigMail){

                session()->flash('success', 'Mail Confugration Inserted');
               return redirect()->route('load_mail_config_form');

             }else{

                session()->flash('error', 'Mail Confugration Not Inserted');
               return redirect()->route('load_mail_config_form');

             }

      
    }

    public function updateMailConfig(Request $request)
    {
        $data = $request->validate([
            'organisation_id' => 'required|exists:organisation_config_mails,organisation_id',
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_PORT' => 'required',
            'MAIL_USERNAME' => 'required',
            'MAIL_PASSWORD' => 'required',
            'MAIL_ENCRYPTION' => 'required',
            'MAIL_FROM_ADDRESS' => 'required',
            'MAIL_FROM_NAME' => 'required',
        ]);
// dd($data);
        $status = DB::table('organisation_config_mails')
            ->where('organisation_id', $data['organisation_id'])
            ->update([
                'MAIL_MAILER' => $data['MAIL_MAILER'],
                'MAIL_HOST' => $data['MAIL_HOST'],
                'MAIL_PORT' => $data['MAIL_PORT'],
                'MAIL_USERNAME' => $data['MAIL_USERNAME'],
                'MAIL_PASSWORD' => $data['MAIL_PASSWORD'],
                'MAIL_ENCRYPTION' => $data['MAIL_ENCRYPTION'],
                'MAIL_FROM_ADDRESS' => $data['MAIL_FROM_ADDRESS'],
                'MAIL_FROM_NAME' => $data['MAIL_FROM_NAME'],
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('load_mail_config_form')->with('success', 'Mail Configuration updated successfully.');
        } else {
            return redirect()->route('load_mail_config_form')->with('error', 'Failed to update Mail Configuration.');
        }
    }
}


