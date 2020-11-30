<?php

namespace App\Core;

abstract class Model extends DbModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MATCH = 'match';

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

    public function validateModelData()
    {
        $modelRules = $this->rules();

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
                }

            }
        }

        return empty($this->errors);
    }

    private function addError($property, $rule, $params = [])
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
        ];
    }
}
