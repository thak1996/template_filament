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
            'mensagem' => 'nullable'
        ]);

        $lead = Lead::create($data);

        Mail::to('seu-email@franklyndev.com.br')->send(new NewLeadNotification($lead));

        return back()->with('success', 'Lead capturado com sucesso!');
    }
}
