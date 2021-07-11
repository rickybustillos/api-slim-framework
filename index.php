<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Loading all vendor dependencies
require 'vendor/autoload.php';

$app = new \Slim\App;

// PSR-7
$app->group('/v1', function () {

  $this->group('/categories', function () {

    $this->get('[/{id}]', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      if ($id) {
        $response->getBody()->write(json_encode($id));
      } else {
        $response->getBody()->write('Listagem de postagens');
      }
      return $response;
    });

    $this->post('', function (Request $request, Response $response) {
      $post = $request->getParsedBody();
      $dados = [
        'name' => $post['name'],
        'description' => $post['description']
      ];
      return $response->getBody()->write(json_encode($dados));
    });

    $this->put('/{id}', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      $post = $request->getParsedBody();
      $dados = [
        'dados' => [
          'id' => $id,
          'name' => $post['name'],
          'description' => $post['description']
        ],
        'status' => true
      ];
      return $response->getBody()->write(json_encode($dados));
    });

    $this->delete('/{id}', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      $dados = [
        'dados' => [
          'id' => $id,
        ],
        'status' => true
      ];
      return $response->getBody()->write(json_encode($dados));
    });
  });
});

$app->run();
