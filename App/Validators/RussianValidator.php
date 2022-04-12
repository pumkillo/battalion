<?php
require_once(__DIR__ . '/AbstractValidator.php');

class RussianValidator extends AbstractValidator
{
    public function rule(): bool
    {
        return (bool)preg_match('/^([а-я\s\d\W])*$/ui', $this->value);
    }

    public function message(): string
    {
        return 'Поле :field может содержать только символы русского алфавита и пробелы.';
    }
}
