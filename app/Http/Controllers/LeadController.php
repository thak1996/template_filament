<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLeadWebhookJob;
use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function webhook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'     => 'required|string|max:255',
            'email'    => 'required|email',
            'telefone' => 'nullable|string|max:20',
            'mensagem' => 'nullable',
        ], [
            'nome.required'  => 'Provide the name.',
            'email.required' => 'Provide the email.',
            'email.email'    => 'Provide a valid email.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $lead = Lead::create($validator->validated());

        ProcessLeadWebhookJob::dispatch($lead);

        return response()->json([
            'success' => true,
            'message' => 'Lead recebido e sendo processado.',
            'id'      => $lead->id
        ], 200);
    }
}
