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
$tableName = 'categories';

$schema->dropIfExists($tableName);

$schema->create($tableName, function($tabke){
  $table->increments('id');
  $table->string('name', 60);
  $table->text('description');
  $table->timestamps();
});