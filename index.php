<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Loading all vendor dependencies
require 'vendor/autoload.php';

$app = new \Slim\App;

$app->group('/v1', function () {

  $this->group('/categories', function () {

    $this->get('[/{id}]', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      if ($id) {
        $response->withJson($id);
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
      return $response->withJson($dados);
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
      return $response->withJson($dados);
    });

    $this->delete('/{id}', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      $dados = [
        'dados' => [
          'id' => $id,
        ],
        'status' => true
      ];
      return $response->withJson($dados);
    });
  });
});

$app->run();
