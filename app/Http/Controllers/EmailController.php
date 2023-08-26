<?php

namespace App\Http\Controllers;

use App\Mail\MyFirstMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendDemoEmail(): string
    {
        $data = 'Hello World';
        $filePath = [
            'attachment'=> public_path('storage/events/ss.png')
        ];
        Mail::to('m.nuryyev98@gmail.com')->send(new MyFirstMail($data, $filePath));
        return 'Email sent Successfully';
    }
}
