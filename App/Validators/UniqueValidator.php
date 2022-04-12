<?php
require_once(__DIR__ . '/../Loader.php');
require_once(Loader::load('query'));
require_once(__DIR__ . '/AbstractValidator.php');

class UniqueValidator extends AbstractValidator
{
    public function rule(): bool
    {
        return (bool)count(Query::table($this->args[0])->where($this->args[1] . " LIKE '" . $this->value . "'")) == 0;
    }

    public function message(): string
    {
        return 'Поле :field должно быть уникально.';
    }
}
