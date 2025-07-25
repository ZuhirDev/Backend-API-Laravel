<?php

use App\Events\NotificationEvent;
use App\Events\NotificationPrivateEvent;
use Illuminate\Support\Facades\Route;
use Illuminate\Broadcasting\BroadcastController;

Route::get('/', function(){
    return response()->json(["message" => "Estas en la ruta '/' de api.php"]);
})->name('login');

Route::get('languages', function(){
    return response()->json(config('languages'));
});

Route::post('/broadcasting/auth', [BroadcastController::class, 'authenticate'])->middleware('auth:api');

Route::get('/notification', function () {
    NotificationPrivateEvent::dispatch('Hello from back with WebSocket');
    return response()->json(['status' => 'Notification sent']);
});

require __DIR__ . '/auth.php';
