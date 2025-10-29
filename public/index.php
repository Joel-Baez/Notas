<?php

use App\Controllers\GradeController;
use App\Controllers\ProgramController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;

spl_autoload_register(function (string $class) {
    if (str_starts_with($class, 'App\\')) {
        $path = __DIR__ . '/../' . str_replace('App\\', 'app/', $class) . '.php';
        $path = str_replace('\\', '/', $path);
        if (file_exists($path)) {
            require_once $path;
        }
    }
});

$entity = $_GET['entity'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($entity) {
    case 'programs':
        $controller = new ProgramController();
        match ($action) {
            'create' => $controller->create(),
            'store' => $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->store() : $controller->index(),
            'edit' => isset($_GET['code']) ? $controller->edit($_GET['code']) : $controller->index(),
            'update' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->update($_GET['code']) : $controller->index(),
            'confirmDelete' => isset($_GET['code']) ? $controller->confirmDelete($_GET['code']) : $controller->index(),
            'destroy' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->destroy($_GET['code']) : $controller->index(),
            'show' => isset($_GET['code']) ? $controller->show($_GET['code']) : $controller->index(),
            default => $controller->index(),
        };
        break;
    case 'students':
        $controller = new StudentController();
        match ($action) {
            'create' => $controller->create(),
            'store' => $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->store() : $controller->index(),
            'edit' => isset($_GET['code']) ? $controller->edit($_GET['code']) : $controller->index(),
            'update' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->update($_GET['code']) : $controller->index(),
            'confirmDelete' => isset($_GET['code']) ? $controller->confirmDelete($_GET['code']) : $controller->index(),
            'destroy' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->destroy($_GET['code']) : $controller->index(),
            'show' => isset($_GET['code']) ? $controller->show($_GET['code']) : $controller->index(),
            default => $controller->index(),
        };
        break;
    case 'subjects':
        $controller = new SubjectController();
        match ($action) {
            'create' => $controller->create(),
            'store' => $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->store() : $controller->index(),
            'edit' => isset($_GET['code']) ? $controller->edit($_GET['code']) : $controller->index(),
            'update' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->update($_GET['code']) : $controller->index(),
            'confirmDelete' => isset($_GET['code']) ? $controller->confirmDelete($_GET['code']) : $controller->index(),
            'destroy' => isset($_GET['code']) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->destroy($_GET['code']) : $controller->index(),
            'show' => isset($_GET['code']) ? $controller->show($_GET['code']) : $controller->index(),
            default => $controller->index(),
        };
        break;
    case 'grades':
        $controller = new GradeController();
        match ($action) {
            'create' => $controller->create(),
            'store' => $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->store() : $controller->index(),
            'edit' => (isset($_GET['subject'], $_GET['student'], $_GET['activity'])) ? $controller->edit($_GET['subject'], $_GET['student'], $_GET['activity']) : $controller->index(),
            'update' => (isset($_GET['subject'], $_GET['student'], $_GET['activity'])) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->update($_GET['subject'], $_GET['student'], $_GET['activity']) : $controller->index(),
            'confirmDelete' => (isset($_GET['subject'], $_GET['student'], $_GET['activity'])) ? $controller->confirmDelete($_GET['subject'], $_GET['student'], $_GET['activity']) : $controller->index(),
            'destroy' => (isset($_GET['subject'], $_GET['student'], $_GET['activity'])) && $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->destroy($_GET['subject'], $_GET['student'], $_GET['activity']) : $controller->index(),
            'deleteAllForStudent' => isset($_GET['student']) ? $controller->deleteAllForStudent($_GET['student']) : $controller->index(),
            default => $controller->index(),
        };
        break;
    default:
        include __DIR__ . '/../app/views/home/index.php';
        break;
}
