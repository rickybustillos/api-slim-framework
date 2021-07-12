<?php
if (PHP_SAPI == 'cli') {
  exit('This application needs to run via CLI');
}

require __DIR__ . '/vendor/autoload.php';

$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/src/dependencies.php';

$db = $container->get('db');

$schema = $db->schema();

if (!$schema->hasTable('categories')) {
  $schema->create('categories', function($table){
    $table->increments('id');
    $table->string('name', 60);
    $table->text('description');
    $table->timestamps();
  });
  echo shell_exec('echo categories table generated!');
}

$schema->create($tableName, function($tabke){
  $table->increments('id');
  $table->string('name', 60);
  $table->text('description');
  $table->timestamps();
});