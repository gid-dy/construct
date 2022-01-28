<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Feedback;
use App\Services;
use Validator;

class FeedbackController extends Controller
{
    public function feedback(Request $request, $id = null){
        $feedbacks = Services::where(['id'=>$id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'Service_id' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $feedbacks = new Feedback;
            $feedbacks->Service_id =$data['Service_id'];
            $feedbacks->SurName = $data['SurName'];
            $feedbacks->OtherNames =$data['OtherNames'];
            $feedbacks->email =$data['email'];
            $feedbacks->Message =$data['Message'];
            $feedbacks->Status = 1;
            //dd($feedbacks);
            $feedbacks->save();

            //send Contact Email
            $email ="ghanatrek.toursite@gmail.com";
            $messageData = [
                'Service_id'=>$data['Service_id'],
                'SurName'=>$data['SurName'],
                'OtherNames'=>$data['OtherNames'],
                'email'=>$data['email'],
                'comment'=>$data['Message']
            ];
            Mail::send('emails.feedback', $messageData, function($message)use($email){
                $message->to($email)->subject('feedback from MS World');
            });
            return redirect()->back()->with('flash_message_success', 'Thanks for your feedback. We will get back to you soon.');


        }
        return view('service.details')->with(compact('feedbacks'));
    }

    public function viewFeedback(){
        $feedbacks = Feedback::get();
        return view('admin.feedbacks.view_feedback')->with(compact('feedbacks'));
    }

    public function updateFeedbackStatus($id, $Status){
        Feedback::where('id', $id)->update(['Status'=>$Status]);
        return redirect()->back()->with('flash_message_success', 'Feddback Status has been updated');
    }

    public function deleteFeedback($id){
        Feedback::where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success', 'Feedback has been deleted');
    }
}
