<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Program;
use App\Models\Subject;

class SubjectController extends BaseController
{
    private Subject $subjectModel;
    private Program $programModel;
    private Grade $gradeModel;

    public function __construct()
    {
        $this->subjectModel = new Subject();
        $this->programModel = new Program();
        $this->gradeModel = new Grade();
    }

    public function index(): void
    {
        $programFilter = $_GET['program'] ?? '';
        $subjects = $programFilter ? $this->subjectModel->allByProgram($programFilter) : $this->subjectModel->all();
        $programs = $this->programModel->all();

        $this->render('subjects/index', [
            'subjects' => $subjects,
            'programs' => $programs,
            'programFilter' => $programFilter,
        ]);
    }

    public function create(): void
    {
        $programs = $this->programModel->all();
        $this->render('subjects/form', ['subject' => null, 'programs' => $programs, 'errors' => []]);
    }

    public function store(): void
    {
        $data = [
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        $errors = $this->validate($data, true);

        if (!$errors) {
            try {
                $this->subjectModel->create($data);
                header('Location: index.php?entity=subjects&status=created');
                return;
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $programs = $this->programModel->all();
        $this->render('subjects/form', ['subject' => $data, 'programs' => $programs, 'errors' => $errors]);
    }

    public function edit(string $code): void
    {
        $subject = $this->subjectModel->find($code);
        if (!$subject) {
            header('Location: index.php?entity=subjects&error=not_found');
            return;
        }

        $programs = $this->programModel->all();
        $this->render('subjects/form', ['subject' => $subject, 'programs' => $programs, 'errors' => []]);
    }

    public function update(string $code): void
    {
        $subject = $this->subjectModel->find($code);
        if (!$subject) {
            header('Location: index.php?entity=subjects&error=not_found');
            return;
        }

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        $errors = $this->validate(array_merge($subject, $data), false);

        if (!$errors) {
            try {
                if ($this->subjectModel->update($code, $data, $errors)) {
                    header('Location: index.php?entity=subjects&status=updated');
                    return;
                }
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $programs = $this->programModel->all();
        $this->render('subjects/form', ['subject' => array_merge($subject, $data), 'programs' => $programs, 'errors' => $errors]);
    }

    public function confirmDelete(string $code): void
    {
        $subject = $this->subjectModel->find($code);
        if (!$subject) {
            header('Location: index.php?entity=subjects&error=not_found');
            return;
        }

        $this->render('subjects/delete', ['subject' => $subject, 'errors' => []]);
    }

    public function destroy(string $code): void
    {
        $subject = $this->subjectModel->find($code);
        if (!$subject) {
            header('Location: index.php?entity=subjects&error=not_found');
            return;
        }

        $errors = [];
        if ($this->subjectModel->delete($code, $errors)) {
            header('Location: index.php?entity=subjects&status=deleted');
            return;
        }

        $this->render('subjects/delete', ['subject' => $subject, 'errors' => $errors]);
    }

    public function show(string $code): void
    {
        $subject = $this->subjectModel->find($code);
        if (!$subject) {
            header('Location: index.php?entity=subjects&error=not_found');
            return;
        }

        $students = $this->gradeModel->getSubjectStudentAverages($code);
        $grades = $this->gradeModel->allBySubject($code);

        $this->render('subjects/show', [
            'subject' => $subject,
            'students' => $students,
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

        if (empty($data['programa'])) {
            $errors[] = 'El programa de formación es obligatorio.';
        }

        return $errors;
    }
}
