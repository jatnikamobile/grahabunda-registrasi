<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
// use Closure;
// use Illuminate\Foundation\Application;
// use Illuminate\Support\InteractsWithTime;
// use Symfony\Component\HttpFoundation\Cookie;
// use Illuminate\Contracts\Encryption\Encrypter;
// use Illuminate\Session\TokenMismatchException;
// use Illuminate\Cookie\Middleware\EncryptCookies;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //

        
    ];

    // protected function addCookieToResponse($request, $response)
    // {
    //     $config = config('session');

    //     $response->headers->setCookie(
    //         new Cookie(
    //             'PENDAFTARAN-XSRF-TOKEN', $request->session()->token(), $this->availableAt(60 * $config['lifetime']),
    //             $config['path'], $config['domain'], $config['secure'], false, false, $config['same_site'] ?? null
    //         )
    //     );

    //     return $response;
    // }

    // public static function serialized()
    // {
    //     return EncryptCookies::serialized('PENDAFTARAN-XSRF-TOKEN');
    // }
}
