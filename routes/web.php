<?php

use App\Jobs\QueueHealthCheckJob;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('switch-language');

if (app()->environment('local')) {
    Route::get('/dev/queue-test', function () {
        $reference = (string) Str::uuid();

        QueueHealthCheckJob::dispatch('web', $reference);

        return response()->json([
            'status' => 'queued',
            'reference' => $reference,
            'message' => 'Job de teste enviado para a fila. Verifique os logs do worker.',
        ]);
    })->name('dev.queue.test');
}
