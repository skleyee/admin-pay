<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiXSign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = config('app.api.key');
        $secret = config('app.api.secret');
        $data = $request->post();
        $apiSign = $request->header('X-Sign');
        logger($apiSign);
        ksort($data);

        $data['k'] = $apiKey;

        $jsonString = json_encode($data);

        $cleanJsonString = str_replace('/', '\/', $jsonString);

        $calculatedSignature = hash_hmac('sha256', $cleanJsonString, $secret);
        if (!hash_equals($calculatedSignature, $apiSign)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature'
            ], 401);
        }

        return $next($request);
    }
}
