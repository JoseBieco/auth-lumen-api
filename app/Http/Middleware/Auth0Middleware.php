<?php


namespace App\Http\Middleware;


use Closure;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;


class Auth0Middleware
{

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return  response()->json("No token provided", 401);
        }

        $this->validateToken($token);

        return $next($request);
    }

    function validateToken($token)
    {
        try {
            $jwksUri = env('AUTH0_DOMAIN') . '.well-known/jwks.json';

            $jwksFetcher = new JWKFetcher(null, ['base_uri' => $jwksUri]);
            $signatureVerifier = new AsymmetricVerifier($jwksFetcher);
            $tokenVerifier = new TokenVerifier(env('AUTH0_DOMAIN'), env('AUTH0_AUD'), $signatureVerifier);

            return $tokenVerifier->verify($token);
        } catch (InvalidTokenException $e) {
            throw $e;
        }
    }
}
