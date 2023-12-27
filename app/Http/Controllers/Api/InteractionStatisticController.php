<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InteractionEvent;
use Illuminate\Http\Request;

class InteractionStatisticController extends Controller
{
    public function statistic_info(Request $req) {
        $statistics = InteractionEvent::groupBy('interaction_id')
            ->selectRaw('interaction_id, COUNT(*) as event_count')
            ->get();

        return response()->json(['status' => 200, 'data' => $statistics]);
    }
} 
