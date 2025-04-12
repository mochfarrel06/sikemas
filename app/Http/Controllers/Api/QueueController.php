<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queues = Queue::with('doctor')->get();
        } else {
            $queues = Queue::with('doctor')->where('user_id', $user->id)->get();
        }

        return response()->json([
            'data' => $queues,
        ], 200);
    }
}
