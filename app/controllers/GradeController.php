<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;

class GradeController extends BaseController
{
    private Grade $gradeModel;
    private Student $studentModel;
    private Subject $subjectModel;

    public function __construct()
    {
        $this->gradeModel = new Grade();
        $this->studentModel = new Student();
        $this->subjectModel = new Subject();
    }

    public function index(): void
    {
        $studentFilter = $_GET['student'] ?? '';
        $subjectFilter = $_GET['subject'] ?? '';

        if ($studentFilter) {
            $grades = $this->gradeModel->allByStudent($studentFilter);
        } elseif ($subjectFilter) {
            $grades = $this->gradeModel->allBySubject($subjectFilter);
        } else {
            $grades = [];
        }

        $students = $this->studentModel->all();
        $subjects = $this->subjectModel->all();

        $this->render('grades/index', [
            'grades' => $grades,
            'students' => $students,
            'subjects' => $subjects,
            'studentFilter' => $studentFilter,
            'subjectFilter' => $subjectFilter,
        ]);
    }

    public function create(): void
    {
        $students = $this->studentModel->all();
        $subjects = $this->subjectModel->all();
        $this->render('grades/form', ['grade' => null, 'students' => $students, 'subjects' => $subjects, 'errors' => []]);
    }

    public function store(): void
    {
        $data = [
            'estudiante' => trim($_POST['estudiante'] ?? ''),
            'materia' => trim($_POST['materia'] ?? ''),
            'actividad' => trim($_POST['actividad'] ?? ''),
            'nota' => trim($_POST['nota'] ?? ''),
        ];

        $errors = $this->validate($data, true);

        if (!$errors) {
            try {
                if ($this->gradeModel->create($data, $errors)) {
                    header('Location: index.php?entity=grades&status=created&student=' . urlencode($data['estudiante']));
                    return;
                }
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $students = $this->studentModel->all();
        $subjects = $this->subjectModel->all();
        $this->render('grades/form', ['grade' => $data, 'students' => $students, 'subjects' => $subjects, 'errors' => $errors]);
    }

    public function edit(string $subject, string $student, string $activity): void
    {
        $grade = $this->gradeModel->find($subject, $student, $activity);
        if (!$grade) {
            header('Location: index.php?entity=grades&error=not_found');
            return;
        }

        $this->render('grades/edit', ['grade' => $grade, 'errors' => []]);
    }

    public function update(string $subject, string $student, string $activity): void
    {
        $grade = $this->gradeModel->find($subject, $student, $activity);
        if (!$grade) {
            header('Location: index.php?entity=grades&error=not_found');
            return;
        }

        $newValue = trim($_POST['nota'] ?? '');
        $errors = $this->validate(array_merge($grade, ['nota' => $newValue]), false);

        if (!$errors) {
            try {
                if ($this->gradeModel->update($subject, $student, $activity, (float) $newValue, $errors)) {
                    header('Location: index.php?entity=grades&status=updated&student=' . urlencode($student));
                    return;
                }
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        $this->render('grades/edit', ['grade' => array_merge($grade, ['nota' => $newValue]), 'errors' => $errors]);
    }

    public function confirmDelete(string $subject, string $student, string $activity): void
    {
        $grade = $this->gradeModel->find($subject, $student, $activity);
        if (!$grade) {
            header('Location: index.php?entity=grades&error=not_found');
            return;
        }

        $this->render('grades/delete', ['grade' => $grade, 'errors' => []]);
    }

    public function destroy(string $subject, string $student, string $activity): void
    {
        $grade = $this->gradeModel->find($subject, $student, $activity);
        if (!$grade) {
            header('Location: index.php?entity=grades&error=not_found');
            return;
        }

        if ($this->gradeModel->delete($subject, $student, $activity)) {
            header('Location: index.php?entity=grades&status=deleted&student=' . urlencode($student));
            return;
        }

        $this->render('grades/delete', ['grade' => $grade, 'errors' => ['No se pudo eliminar la nota.']]);
    }

    public function deleteAllForStudent(string $student): void
    {
        $studentData = $this->studentModel->find($student);
        if (!$studentData) {
            header('Location: index.php?entity=grades&error=not_found');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->gradeModel->deleteAllForStudent($student);
            header('Location: index.php?entity=grades&status=deleted_all&student=' . urlencode($student));
            return;
        }

        $this->render('grades/delete_all', ['student' => $studentData]);
    }

    private function validate(array $data, bool $isCreate): array
    {
        $errors = [];

        if ($isCreate) {
            if (empty($data['estudiante'])) {
                $errors[] = 'El estudiante es obligatorio.';
            }

            if (empty($data['materia'])) {
                $errors[] = 'La materia es obligatoria.';
            }

            if (empty($data['actividad'])) {
                $errors[] = 'La actividad es obligatoria.';
            }
        }

        if (empty($data['nota'])) {
            $errors[] = 'La nota es obligatoria.';
        }

        $student = null;
        $subject = null;

        if (!empty($data['estudiante'])) {
            $student = $this->studentModel->find($data['estudiante']);
            if (!$student) {
                $errors[] = 'El estudiante seleccionado no existe.';
            }
        }

        if (!empty($data['materia'])) {
            $subject = $this->subjectModel->find($data['materia']);
            if (!$subject) {
                $errors[] = 'La materia seleccionada no existe.';
            }
        }

        if ($student && $subject && $student['programa'] !== $subject['programa']) {
            $errors[] = 'La materia seleccionada no pertenece al programa del estudiante.';
        }

        if (!empty($data['nota']) && !is_numeric($data['nota'])) {
            $errors[] = 'La nota debe ser numérica.';
        } elseif (!empty($data['nota']) && (strlen(explode('.', $data['nota'])[1] ?? '') > 2 || (float) $data['nota'] <= 0 || (float) $data['nota'] >= 5)) {
            $errors[] = 'La nota debe ser mayor a 0 y menor a 5 con máximo dos decimales.';
        }

        return $errors;
    }
}
