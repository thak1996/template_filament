<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    public function show()
    {
        return view('quote');
    }
    public function send(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:residential,commercial',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'origin_zipcode' => 'required|string|regex:/^\d{5}-?\d{3}$/',
            'origin_street' => 'required|string|max:255',
            'origin_number' => 'nullable|string|max:20',
            'origin_district' => 'required|string|max:255',
            'origin_city' => 'required|string|max:255',
            'origin_state' => 'required|string|max:255',
            'origin_type' => 'required|in:house,apartment',
            'origin_elevator' => 'required_if:origin_type,apartment|in:yes,no',
            'destination_zipcode' => 'required|string|regex:/^\d{5}-?\d{3}$/',
            'destination_street' => 'required|string|max:255',
            'destination_number' => 'nullable|string|max:20',
            'destination_district' => 'required|string|max:255',
            'destination_city' => 'required|string|max:255',
            'destination_state' => 'required|string|max:255',
            'destination_type' => 'required|in:house,apartment',
            'destination_elevator' => 'required_if:destination_type,apartment|in:yes,no',
            'residential_phone' => 'nullable|string|max:20',
            'commercial_phone' => 'nullable|string|max:20',
            'mobile_phone' => 'required|string|max:20',
            'origin_floor' => 'nullable|string|max:10',
            'destination_floor' => 'nullable|string|max:10',
            'observations' => 'nullable|string|max:1000',
        ], [
            'type.required' => 'O tipo de mudança é obrigatório.',
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'origin_zipcode.required' => 'O CEP de origem é obrigatório.',
            'origin_zipcode.regex' => 'O CEP de origem deve ter o formato 00000-000.',
            'origin_street.required' => 'A rua de origem é obrigatória.',
            'origin_district.required' => 'O bairro de origem é obrigatório.',
            'origin_city.required' => 'A cidade de origem é obrigatória.',
            'origin_state.required' => 'O estado de origem é obrigatório.',
            'origin_type.required' => 'O tipo de imóvel de origem é obrigatório.',
            'origin_elevator.required_if' => 'Informe se há elevador na origem quando for apartamento.',
            'destination_zipcode.required' => 'O CEP de destino é obrigatório.',
            'destination_zipcode.regex' => 'O CEP de destino deve ter o formato 00000-000.',
            'destination_street.required' => 'A rua de destino é obrigatória.',
            'destination_district.required' => 'O bairro de destino é obrigatório.',
            'destination_city.required' => 'A cidade de destino é obrigatória.',
            'destination_state.required' => 'O estado de destino é obrigatório.',
            'destination_type.required' => 'O tipo de imóvel de destino é obrigatório.',
            'destination_elevator.required_if' => 'Informe se há elevador no destino quando for apartamento.',
            'mobile_phone.required' => 'O telefone celular é obrigatório.',
        ]);

        try {
            $emailData = $validated;

            if ($validated['origin_type'] !== 'apartment') {
                $emailData['origin_elevator'] = null;
            }
            if ($validated['destination_type'] !== 'apartment') {
                $emailData['destination_elevator'] = null;
            }

            Mail::send('emails.quote', ['data' => $emailData], function ($message) use ($validated) {
                $message->to(config('mail.from.copy_address'))
                    ->subject('Nova Solicitação de Orçamento - ' . $validated['name'])
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($validated['email'], $validated['name']);
            });

            Mail::send('emails.quote', ['data' => $emailData], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Confirmação - Solicitação de Orçamento FDS Logística')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->back()->with('success', true);
        } catch (\Exception $e) {
            Log::error('Error sending quote emails', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', true);
        }
    }
}
