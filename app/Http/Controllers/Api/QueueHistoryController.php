<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QueueHistory;
use Illuminate\Http\Request;

class QueueHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queueHistories = QueueHistory::all();
        } else {
            $queueHistories = QueueHistory::where('user_id', $user->id)->get();
        }

        return response()->json([
            'data' => $queueHistories,
        ], 200);
    }
}
