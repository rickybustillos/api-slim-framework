<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->group('/api/v1/categories', function () {

  $this->get('[/{id}]', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $db = $this->get('db');

    if ($id) {
      $dados = $db->table('categories')->where('id', $id)->get();
      return $response->withJson($dados);

    } else {
      $dados = $db->table('categories')->get();
      return $response->withJson($dados);

    }
  });

});
