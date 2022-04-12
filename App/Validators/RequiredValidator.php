<?php
require_once(__DIR__ . '/AbstractValidator.php');

class RequiredValidator extends AbstractValidator
{
    public function rule(): bool
    {
        return !empty($this->value);
    }

    public function message(): string
    {
        return 'Поле :field обязательно.';
    }
}
