<?php
class Validators
{
    private array $validators = [
        'required' => 'RequiredValidator',
        'unique' => 'UniqueValidator',
        'russian' => 'RussianValidator',
        'min_max' => 'MinMaxValidator',
        'birthdate' => 'BirthdateValidator',
    ];

    private array $errors = [];
    private array $fields = [];
    private array $rules = [];

    public function __construct(array $fields, array $rules)
    {
        array_map(fn ($value) => strip_tags($value), $fields);
        $this->fields = $fields;
        $this->rules = $rules;
        $this->validate();
    }

    private function validate(): void
    {
        foreach ($this->rules as $fieldName => $fieldValidators) {
            $this->validateField($fieldName, $fieldValidators);
        }
    }

    private function validateField(string $fieldName, array $fieldValidators): void
    {
        foreach ($fieldValidators as $validatorName) {
            $tmp = explode(':', $validatorName);
            [$validatorName, $args] = count($tmp) > 1 ? $tmp : [$validatorName, null];
            $args = isset($args) ? explode(',', $args) : [];

            $validatorClass = $this->validators[$validatorName];
            if (!isset($this->validators[$validatorName])) {
                continue;
            }
            require_once(__DIR__ . '/../App/Validators/' . $validatorClass . '.php');
            $validator = new $validatorClass(
                $fieldName,
                $this->fields[$fieldName],
                $args
            );

            if (!$validator->rule()) {
                $this->errors[$fieldName][] = $validator->validate();
            }
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return (bool)count($this->errors);
    }
}
