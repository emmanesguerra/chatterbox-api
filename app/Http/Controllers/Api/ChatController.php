<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Services\ChatService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    protected $chatService;
    protected $messageService;

    public function __construct(ChatService $chatService, MessageService $messageService)
    {
        $this->chatService = $chatService;
        $this->messageService = $messageService;
    }

    public function chat(ChatRequest $request): JsonResponse
    {
        $response = $this->chatService->chat($request->input('message'));

        if($response) {

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
