<?php

use Slim\Http\Request;
use Slim\Http\Response;
use src\Models\Category;

// Routes
$app->group('/api/v1/categories', function () {

  $this->get('[/{id}]', function (Request $request, Response $response, $args) {

    if ($args['id']) {
      $dados = Category::findOrFail( $args['id'] );
      return $response->withJson($dados);

    } else {
      $dados = Category::get();
      return $response->withJson($dados);

    }
  });

  $this->post('', function (Request $request, Response $response) {
    $post = $request->getParsedBody();
    $dados = Category::create($post);
    return $response->withJson($dados);
  });

  $this->put('/{id}', function (Request $request, Response $response, $args) {
    $post = $request->getParsedBody();
    
    $dados = Category::findOrFail( $args['id'] );
    $dados->update( $post );

    return $response->withJson($dados);
  });

  $this->delete('/{id}', function (Request $request, Response $response, $args) {
    $dados = Category::findOrFail( $args['id'] );
    $dados->delete($args['id']);
    return $response->withJson($dados);
  });
});
