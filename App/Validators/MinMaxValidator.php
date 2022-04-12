<?php
require_once(__DIR__ . '/AbstractValidator.php');

class MinMaxValidator extends AbstractValidator
{
    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        return (bool)preg_match('/^[\w\W\d]{' . $this->args[1] . ',' . $this->args[2] . '}$/u', $this->value);
    }

    public function message(): string
    {
        return 'Поле :field должно содержать минимум ' . $this->args[1] . ' и максимум ' . $this->args[2] . ' символов.';
    }
}