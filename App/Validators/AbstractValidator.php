<?php
abstract class AbstractValidator
{
    protected string $field = '';
    protected $value;
    protected array $args = [];
    protected array $messageKeys = [];

    public function __construct(string $fieldName, $value, $args = [])
    {
        $this->field = $fieldName;
        $this->value = $value;
        $this->args = $args;

        $this->messageKeys = [
            ":value" => $this->value,
            ":field" => $this->field
        ];
    }

    public function validate()
    {
        return ($this->rule()) ? true : $this->messageError();
    }

    private function messageError(): string
    {
        foreach ($this->messageKeys as $key => $value) {
            $message = str_replace($key, (string)$value, $this->message());
        }
        return $message;
    }

    abstract public function message(): string;
    
    abstract public function rule(): bool;
}
