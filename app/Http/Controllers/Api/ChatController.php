<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Services\GeminiService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    protected $geminiService;
    protected $messageService;

    public function __construct(GeminiService $geminiService, MessageService $messageService)
    {
        $this->geminiService = $geminiService;
        $this->messageService = $messageService;
    }

    public function processMessage(ChatRequest $request): JsonResponse
    {
        $response = $this->geminiService->getResponse($request->input('message'));

        if(isset($response['success']) && $response['success']) {

            $this->messageService->createMessage([
                'conversation_id' => $request->input('conversation_id'),
                'sender' => 'user',
                'message' => $request->input('message')
            ]);
            
            $this->messageService->createMessage([
                'conversation_id' => $request->input('conversation_id'),
                'sender' => 'bot',
                'message' => $response['message']
            ]);
        } 

        return response()->json($response);
    }
}
