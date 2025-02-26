<?php

use App\Http\Controllers\Api\ChatController;

Route::post('/chat', [ChatController::class, 'chat']);
