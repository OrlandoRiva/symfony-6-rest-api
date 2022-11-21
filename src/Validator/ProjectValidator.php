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
        $themeError = $validator->validateProperty($project, 'theme');

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

        if (count($themeError) > 0) {
            foreach ($themeError as $error) {
                $this->errors['themeError'] = $error->getMessage();
            }
        }

        return $this->errors;
    }
}