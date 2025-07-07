<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'phone.required' => 'O telefone é obrigatório.',
            'subject.required' => 'O assunto é obrigatório.',
            'message.required' => 'A mensagem é obrigatória.',
        ]);

        try {
            Mail::send('emails.contact-company', ['data' => $validated], function ($message) use ($validated) {
                $message->to(config('mail.from.copy_address'))
                    ->subject('Nova Mensagem de Contato - ' . $validated['subject'])
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($validated['email'], $validated['name']);
            });

            Mail::send('emails.contact-user', ['data' => $validated], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Confirmação - Mensagem Recebida - FDS Logística')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->back()->with('success', true);
        } catch (\Exception $e) {
            Log::error('Error sending contact emails', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', true);
        }
    }
}
