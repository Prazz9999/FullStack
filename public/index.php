<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../app/controllers/StudentController.php';


use Jenssegers\Blade\Blade;


$blade = new Blade(__DIR__ . '/../app/views', __DIR__ . '/../cache/views');


$controller = new StudentController($conn, $blade);


$page = $_GET['page'] ?? 'index';
$id = $_GET['id'] ?? null;


switch ($page) {
case 'create': $controller->create(); break;
case 'store': $controller->store(); break;
case 'edit': $controller->edit($id); break;
case 'update': $controller->update($id); break;
case 'delete': $controller->delete($id); break;
default: $controller->index();
}