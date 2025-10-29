<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Program;
use App\Models\Student;
use App\Models\Subject;

class StudentController extends BaseController
{
    private Student $studentModel;
    private Program $programModel;
    private Grade $gradeModel;
    private Subject $subjectModel;

    public function __construct()
    {
        $this->studentModel = new Student();
        $this->programModel = new Program();
        $this->gradeModel = new Grade();
        $this->subjectModel = new Subject();
    }

    public function index(): void
    {
        $programFilter = $_GET['program'] ?? '';
        $students = $programFilter ? $this->studentModel->allByProgram($programFilter) : $this->studentModel->all();
        $programs = $this->programModel->all();

        $this->render('students/index', [
            'students' => $students,
            'programs' => $programs,
            'programFilter' => $programFilter,
        ]);
    }

    public function create(): void
    {
        $programs = $this->programModel->all();
        $this->render('students/form', ['student' => null, 'programs' => $programs, 'errors' => []]);
    }

    public function store(): void
    {
        $data = [
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        $errors = $this->validate($data, true);

        if (!$errors) {
            try {
                $this->studentModel->create($data);
                header('Location: index.php?entity=students&status=created');
                return;
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $programs = $this->programModel->all();
        $this->render('students/form', ['student' => $data, 'programs' => $programs, 'errors' => $errors]);
    }

    public function edit(string $code): void
    {
        $student = $this->studentModel->find($code);
        if (!$student) {
            header('Location: index.php?entity=students&error=not_found');
            return;
        }

        $programs = $this->programModel->all();
        $this->render('students/form', ['student' => $student, 'programs' => $programs, 'errors' => []]);
    }

    public function update(string $code): void
    {
        $student = $this->studentModel->find($code);
        if (!$student) {
            header('Location: index.php?entity=students&error=not_found');
            return;
        }

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        $errors = $this->validate(array_merge($student, $data), false);

        if (!$errors) {
            try {
                if ($this->studentModel->update($code, $data, $errors)) {
                    header('Location: index.php?entity=students&status=updated');
                    return;
                }
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $programs = $this->programModel->all();
        $this->render('students/form', ['student' => array_merge($student, $data), 'programs' => $programs, 'errors' => $errors]);
    }

    public function confirmDelete(string $code): void
    {
        $student = $this->studentModel->find($code);
        if (!$student) {
            header('Location: index.php?entity=students&error=not_found');
            return;
        }

        $this->render('students/delete', ['student' => $student, 'errors' => []]);
    }

    public function destroy(string $code): void
    {
        $student = $this->studentModel->find($code);
        if (!$student) {
            header('Location: index.php?entity=students&error=not_found');
            return;
        }

        $errors = [];
        if ($this->studentModel->delete($code, $errors)) {
            header('Location: index.php?entity=students&status=deleted');
            return;
        }

        $this->render('students/delete', ['student' => $student, 'errors' => $errors]);
    }

    public function show(string $code): void
    {
        $student = $this->studentModel->find($code);
        if (!$student) {
            header('Location: index.php?entity=students&error=not_found');
            return;
        }

        $subjectsWithAverage = $this->gradeModel->getProgramSubjectsWithAverageForStudent($student['programa'], $code);
        $grades = $this->gradeModel->allByStudent($code);

        $this->render('students/show', [
            'student' => $student,
            'subjectsWithAverage' => $subjectsWithAverage,
            'grades' => $grades,
        ]);
    }

    private function validate(array $data, bool $isCreate): array
    {
        $errors = [];
        if ($isCreate && empty($data['codigo'])) {
            $errors[] = 'El código es obligatorio.';
        }

        if (empty($data['nombre'])) {
            $errors[] = 'El nombre es obligatorio.';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El correo electrónico no es válido.';
        }

        if (empty($data['programa'])) {
            $errors[] = 'El programa de formación es obligatorio.';
        }

        return $errors;
    }
}
