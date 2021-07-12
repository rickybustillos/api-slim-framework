<?php

use Slim\Http\Request;
use Slim\Http\Response;
use src\Models\Category;
use src\Models\User;
use Firebase\JWT\JWT;

// Token generation route
$app->post('/api/token', function (Request $request, Response $response) {
  
  $post = $request->getParsedBody();

  $email = $post['email'] ?? null;
  $password = $post['password'] ?? null;

  $user = User::where('email', $email)->first();
  if(!is_null($user) && (sha1($password) === $user->password) ) {

    // generate token
    $secretKey = $this->get('settings')['secretKey'];
    $token = JWT::encode($user, $secretKey);

    return $response->withJson([
      'token' => $token
    ]);
  }

  return $response->withJson([
    'status' => 'error'
  ], 401);

});