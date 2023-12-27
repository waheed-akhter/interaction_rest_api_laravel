<?php

namespace App\Http\Middleware;

use App\Models\Interaction;
use App\Models\InteractionEvent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InteractionMiddleware
{
    /** 
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->server->get('REMOTE_ADDR');
        $id = $request->route('id'); 
        $interaction = Interaction::find($id);
 
        if (!empty($interaction)) {
            $n = new InteractionEvent();
            $n->interaction_id = $id;
            $n->event_type = "click";
            $n->ip_address = $ip;
            $n->save(); 
        }

 
        

        return $next($request);
    }
}
