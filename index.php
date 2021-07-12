<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

// Loading all vendor dependencies
require 'vendor/autoload.php';

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true
  ]
]);

$container = $app->getContainer();
$container['db'] = function(){
  
  $capsule = new Capsule;
  $capsule->addConnection([
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'slim',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
  ]);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  return $capsule;
};

$app->group('/v1', function () {

  $this->group('/categories', function () {

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

    $this->post('', function (Request $request, Response $response) {
      $post = $request->getParsedBody();
      $dados = [
        'name' => $post['name'],
        'description' => $post['description']
      ];

      $db = $this->get('db');
      $db->table('categories')->insert($dados);
      
      return $response->withJson($dados);
    });

    $this->put('/{id}', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      $post = $request->getParsedBody();
      $dados = [
        'name' => $post['name'],
        'description' => $post['description']
      ];

      $db = $this->get('db');
      $db->table('categories')->where('id', $id)->update($dados);

      return $response->withJson($dados);
    });

    $this->delete('/{id}', function (Request $request, Response $response) {
      $id = $request->getAttribute('id');
      $dados = [
        'deletedId' => $id,
      ];

      $db = $this->get('db');
      $db->table('categories')->where('id', $id)->delete();

      return $response->withJson($dados);
    });
  });
});

$app->run();