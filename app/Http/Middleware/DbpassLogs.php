<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;
use App\Models\Logs;

class DbpassLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $payload = $request->url();
        $storeSession = [
            'session_id' => Session::getId(),
            'user_id' => Auth::user()->NamaUser,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'payload'   => urlencode(base64_encode($payload)),
            'create_at' => time(),
            'app_name' => urlencode(base64_encode('Modul Registrasi')),
        ];
        $store = Logs::insert($storeSession);
        return $next($request);
    }
}
