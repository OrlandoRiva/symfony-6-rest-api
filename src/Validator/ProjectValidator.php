<?php

namespace App\Validator;

use App\Entity\Project;

class ProjectValidator
{
    public array $errors = [];

    public function validation($validator, Project $project): array
    {
        $nameError = $validator->validateProperty($project, 'name');
        $descriptionError = $validator->validateProperty($project, 'description');

        if (count($nameError) > 0) {
            foreach ($nameError as $error) {
                $this->errors['nameError'] = $error->getMessage();
            }
        }

        if (count($descriptionError) > 0) {
            foreach ($descriptionError as $error) {
                $this->errors['descriptionError'] = $error->getMessage();
            }
        }

        return $this->errors;
    }
}