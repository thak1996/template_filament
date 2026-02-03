<?php

namespace App\Http\Controllers;

use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'nullable|string|max:20',
            'mensagem' => 'nullable',
        ], [
            'nome.required' => 'Informe o nome.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'telefone.max' => 'O telefone pode ter no máximo 20 caracteres.',
        ]);

        $lead = Lead::create($data);

        Mail::to(config('site.from_email'))->send(new NewLeadNotification($lead));

        return back()->with('success');
    }
}
