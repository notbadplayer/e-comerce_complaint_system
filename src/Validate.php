<?php
declare(Strict_types=1);

namespace App;

class Validate
{
    private bool $pass;
    private array $messages;

    public function validate(array $data): array
    {
        $this->pass = true;
        $this->messages = [];

        $this->customerRules($data['customer']);
        $this->objectRules($data['object']);
        $this->descriptionRules($data['description']);
        $this->termRules($data['term'], $data['created']);

        return [
            'messages' => $this->messages,
            'pass' => $this->pass
        ];
    }

    private function customerRules(string $param): void
    {
        if (strlen($param) < 3) {
            $this->messages['customer'][] = "Nazwa klienta nie może być krótsza niż 3 znaki";
            $this->pass = false;
        } elseif (strlen($param) > 100) {
            $this->messages['customer'][] = "Nazwa klienta nie może zawierać więcej niż 100 znaków";
            $this->pass = false;
        }
    }
    private function objectRules(string $param): void
    {
        if(!$param) {
            $this->messages['object'][] = "Pole przedmiot zlecenia nie może być puste";
            $this->pass = false;
        } elseif (strlen($param) > 200) {
            $this->messages['object'][] = "Pole przedmiot zlecenia nie może zawierać więcej niż 200 znaków";
            $this->pass = false;
        }
    }

    private function descriptionRules(string $param): void
    {
        if(!$param) {
            $this->messages['description'][] = "Opis zlecenia jest wymagany!";
            $this->pass = false;
        } elseif (strlen($param) > 300) {
            $this->messages['description'][] = "Opis nie może zawierać więcej niż 300 znaków";
            $this->pass = false;
        }
    }

    private function termRules(string $param, string $comparisionData): void
    {
        if(!$param) {
            $this->messages['term'][] = "Pole z datą wykonania zlecenia nie może być puste";
            $this->pass = false;
        } elseif(strtotime($param) < strtotime($comparisionData)){
            $this->messages['term'][] = "Termin zlecenia nie może być starszy niż jego utworzenie";
            $this->pass = false;
        }
    }
}