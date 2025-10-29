<?php

namespace App\Controllers;

use App\Models\Program;
use App\Models\Student;
use App\Models\Subject;

class ProgramController extends BaseController
{
    private Program $programModel;
    private Student $studentModel;
    private Subject $subjectModel;

    public function __construct()
    {
        $this->programModel = new Program();
        $this->studentModel = new Student();
        $this->subjectModel = new Subject();
    }

    public function index(): void
    {
        $programs = $this->programModel->all();
        $this->render('programs/index', ['programs' => $programs]);
    }

    public function show(string $code): void
    {
        $program = $this->programModel->find($code);
        if (!$program) {
            header('Location: index.php?entity=programs&error=not_found');
            return;
        }

        $students = $this->studentModel->allByProgram($code);
        $subjects = $this->subjectModel->allByProgram($code);

        $this->render('programs/show', [
            'program' => $program,
            'students' => $students,
            'subjects' => $subjects,
        ]);
    }

    public function create(): void
    {
        $this->render('programs/form', ['program' => null, 'errors' => []]);
    }

    public function store(): void
    {
        $data = [
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
        ];

        $errors = $this->validate($data, true);

        if (!$errors) {
            try {
                $this->programModel->create($data);
                header('Location: index.php?entity=programs&status=created');
                return;
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $this->render('programs/form', ['program' => $data, 'errors' => $errors]);
    }

    public function edit(string $code): void
    {
        $program = $this->programModel->find($code);
        if (!$program) {
            header('Location: index.php?entity=programs&error=not_found');
            return;
        }

        $this->render('programs/form', ['program' => $program, 'errors' => []]);
    }

    public function update(string $code): void
    {
        $program = $this->programModel->find($code);
        if (!$program) {
            header('Location: index.php?entity=programs&error=not_found');
            return;
        }

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
        ];

        $errors = $this->validate(array_merge($program, $data), false);

        if (!$errors) {
            try {
                if ($this->programModel->update($code, $data, $errors)) {
                    header('Location: index.php?entity=programs&status=updated');
                    return;
                }
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $this->render('programs/form', ['program' => array_merge($program, $data), 'errors' => $errors]);
    }

    public function confirmDelete(string $code): void
    {
        $program = $this->programModel->find($code);
        if (!$program) {
            header('Location: index.php?entity=programs&error=not_found');
            return;
        }

        $this->render('programs/delete', ['program' => $program]);
    }

    public function destroy(string $code): void
    {
        $program = $this->programModel->find($code);
        if (!$program) {
            header('Location: index.php?entity=programs&error=not_found');
            return;
        }

        $errors = [];
        if ($this->programModel->delete($code, $errors)) {
            header('Location: index.php?entity=programs&status=deleted');
            return;
        }

        $this->render('programs/delete', ['program' => $program, 'errors' => $errors]);
    }

    private function validate(array $data, bool $isCreate): array
    {
        $errors = [];
        if ($isCreate) {
            if (empty($data['codigo'])) {
                $errors[] = 'El código es obligatorio.';
            }
        }

        if (empty($data['nombre'])) {
            $errors[] = 'El nombre es obligatorio.';
        }

        return $errors;
    }
}
