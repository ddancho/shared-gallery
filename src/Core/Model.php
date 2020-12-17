<?php

namespace App\Core;

abstract class Model extends DbModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MATCH = 'match';
    public const RULE_PASSWORD = 'password';

    public const RULE_IMAGE_SIZE_ZERO = 'size_zero';
    public const RULE_IMAGE_SIZE_LIMIT = 'size_limit';
    public const RULE_IMAGE_TYPE = 'image_type';
    public const RULE_IMAGE_UPLOAD_ERROR = 'upload_error';

    public $errors = [];

    abstract public function rules();

    public function loadModelData($data)
    {
        foreach ($data as $property => $value) {
            if (\property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function validateModelData($params = [])
    {
        if (empty($params)) {
            $modelRules = $this->rules();
        } else {
            foreach ($params as $key) {
                $modelRules[$key] = $this->rules()[$key];
            }
        }

        foreach ($modelRules as $property => $rules) {
            if (\property_exists($this, $property)) {
                $value = $this->{$property};

                foreach ($rules as $rule) {
                    $ruleType = $rule;

                    if (\is_array($rule)) {
                        $ruleType = $rule[0];
                    }

                    if ($ruleType === self::RULE_REQUIRED && !$value) {
                        $this->addError($property, $ruleType);
                    }

                    if ($ruleType === self::RULE_EMAIL && !\filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($property, $ruleType);
                    }

                    if ($ruleType === self::RULE_UNIQUE) {
                        $dataType = $this->columns()[$property];
                        $record = $this->find($property, $dataType, $value, true);
                        if ($record) {
                            $this->addError($property, $ruleType, ['unique' => $property]);
                        }
                    }

                    if ($ruleType === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                        $this->addError($property, $ruleType, ['match' => $rule['match']]);
                    }

                    if ($ruleType === self::RULE_IMAGE_SIZE_ZERO && $value['size'] == 0) {
                        $this->addError($property, $ruleType);
                    }

                    if ($ruleType === self::RULE_IMAGE_SIZE_LIMIT && $value['size'] > 5000000000) {
                        $this->addError($property, $ruleType);
                    }

                    if ($ruleType === self::RULE_IMAGE_TYPE) {
                        $allowedExt = ['jpg', 'jpeg', 'png'];
                        $type = \strtolower($value['type']);
                        $type = \explode('/', $type)[1];
                        if (!\in_array($type, $allowedExt)) {
                            $this->addError($property, $ruleType, ['type' => $type]);
                        }

                    }

                    if ($ruleType === self::RULE_IMAGE_UPLOAD_ERROR && $value['error'] !== UPLOAD_ERR_OK) {
                        $this->addError($property, $ruleType, ['error' => $value['error']]);
                    }
                }

            }
        }

        return empty($this->errors);
    }

    protected function addError($property, $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule];

        foreach ($params as $key => $value) {
            $message = \str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$property][] = $message;
    }

    private function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'Field is required',
            self::RULE_EMAIL => 'Email is not valid',
            self::RULE_MATCH => 'Field input must be as {match}',
            self::RULE_UNIQUE => 'Record with this {unique} input already exists',
            self::RULE_PASSWORD => 'Password is not valid',
            self::RULE_IMAGE_SIZE_ZERO => 'Image size is zero, nothing to upload',
            self::RULE_IMAGE_SIZE_LIMIT => 'Image size exceeds upload limit of 5MB',
            self::RULE_IMAGE_TYPE => 'Image type must be JPEG, or PNG and not: {type}',
            self::RULE_IMAGE_UPLOAD_ERROR => 'Error uploading file to database: {error}',
        ];
    }
}
