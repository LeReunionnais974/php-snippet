<?php

class FormValidator
{

    private $data;
    private $errors = [];

    public function __construct($formData)
    {
        $this->data = $formData;
    }

    public function validateRequired($fieldName, $errorMessage = 'Ce champ {fieldName} est requis.')
    {
        $value = $this->getFieldValue($fieldName);
        if (empty($value)) {
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateMinLength($fieldName, $minLength, $errorMessage = 'La longueur minimale du champ {fieldName} est de {minLength} caractères.')
    {
        $value = $this->getFieldValue($fieldName);
        if (strlen($value) < $minLength) {
            $errorMessage = str_replace('{minLength}', $minLength, $errorMessage);
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateMaxLength($fieldName, $maxLength, $errorMessage = 'La longueur maximale du champ {fieldName} est de {maxLength} caractères.')
    {
        $value = $this->getFieldValue($fieldName);
        if (strlen($value) > $maxLength) {
            $errorMessage = str_replace('{maxLength}', $maxLength, $errorMessage);
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateEmail($fieldName, $errorMessage = 'Veuillez saisir une adresse e-mail valide.')
    {
        $value = $this->getFieldValue($fieldName);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateString($fieldName, $errorMessage = 'Ce champ {fieldName} doit être une chaîne de caractères.')
    {
        $value = $this->getFieldValue($fieldName);
        if (!is_string($value)) {
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateInteger($fieldName, $errorMessage = 'Ce champ {fieldName} doit être un entier.')
    {
        $value = $this->getFieldValue($fieldName);
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function validateDecimal($fieldName, $errorMessage = 'Ce champ {fieldName} doit être un nombre décimal.')
    {
        $value = $this->getFieldValue($fieldName);
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $errorMessage = str_replace('{fieldName}', $fieldName, $errorMessage);
            $this->addError($fieldName, $errorMessage);
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    private function getFieldValue($fieldName)
    {
        return isset($this->data[$fieldName]) ? $this->data[$fieldName] : null;
    }

    private function addError($fieldName, $errorMessage)
    {
        $this->errors[$fieldName] = $errorMessage;
    }
}
