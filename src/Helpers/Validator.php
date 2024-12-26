<?php

namespace App\Helpers;

class Validator
{
    private array $errors = [];

    /**
     * Проверка, что поле не пустое.
     */
    public function required(string $field, $value): self
    {
        if (empty($value)) {
            $this->errors[$field][] = "Поле '$field' не может быть пустым.";
        }

        return $this;
    }

    /**
     * Проверка, что значение является строкой.
     */
    public function string(string $field, $value): self
    {
        if (!is_string($value)) {
            $this->errors[$field][] = "Поле '$field' должно быть строкой.";
        }

        return $this;
    }

    /**
     * Проверка, что значение является числом.
     */
    public function number(string $field, $value): self
    {
        if (!is_numeric($value)) {
            $this->errors[$field][] = "Поле '$field' должно быть числом.";
        }

        return $this;
    }

    /**
     * Проверка, что значение соответствует формату даты.
     */
    public function date(string $field, $value): self
    {
        if (!\DateTime::createFromFormat('Y-m-d', $value)) {
            $this->errors[$field][] = "Поле '$field' должно быть датой в формате 'YYYY-MM-DD'.";
        }

        return $this;
    }

    /**
     * Проверка, что поле имеет минимальную длину.
     */
    public function minLength(string $field, $value, int $min): self
    {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "Поле '$field' должно быть длиной не менее $min символов.";
        }

        return $this;
    }

    /**
     * Проверка, что поле имеет максимальную длину.
     */
    public function maxLength(string $field, $value, int $max): self
    {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "Поле '$field' должно быть длиной не более $max символов.";
        }

        return $this;
    }

    /**
     * Получение ошибок.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Проверка, есть ли ошибки.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
