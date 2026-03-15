<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     * Test endpoint para verificar autenticación
     */
    public function test(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working',
            'user' => [
                'id' => $request->user()?->id,
                'email' => $request->user()?->email,
                'authenticated' => $request->user() !== null,
            ],
            'guard' => auth()->guard('sanctum')->check() ? 'sanctum' : 'none',
        ]);
    }

    /**
     * Get user chats (simple version)
     */
    public function getChats(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'No authenticated',
                    'user' => null,
                ], 401);
            }

            $chats = $user->chats()
                ->withCount('messages')
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $chats,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null,
            ], 500);
        }
    }
}
