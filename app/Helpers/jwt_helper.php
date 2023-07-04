<?php

use App\Models\UsersModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader))
    {
        throw new Exception('Missing JWT');
    }

    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    // $decodedToken = JWT::decode($encodedToken, $key, 'HS256');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    
    $userModel = new UsersModel();
    $userModel->findUserByEmailAddress($decodedToken->email);
}

function generateJWT(string $email)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'email' => $email,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(), 'HS256');
    return $jwt;
}
