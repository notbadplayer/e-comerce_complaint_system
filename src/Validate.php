<?php

declare(Strict_types=1);

namespace App;

use App\Controller\fileController;

class Validate
{
    public function validate(array $data): array
    {
        $this->pass = true;
        $this->messages = [];

        (isset($data['customer']) ? $this->customerRules($data['customer']) : false);
        (isset($data['object']) ? $this->objectRules($data['object']) : false);
        (isset($data['description']) ? $this->descriptionRules($data['description']): false);
        (isset($data['email']) ? $this->emailRules($data['email']) : false);
        (isset($data['receipt']) ? $this->receiptRules($data['receipt']) : false);
        (isset($data['file']) ? $this->fileRules($data['file']) : false);

        if (isset($data['term'])) { //to zapobiega walidacji terminu podczas 'standardowej' aktualizacji wpisu, tam te pola nie są przesyłane, walidacja zbędna.
            $this->termRules($data['term'], $data['created']);
        }

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

    private function emailRules(string $param): void
    {
        if ($param) {
            if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
                $this->messages['email'][] = "Nieprawidłowy format e-mail";
                $this->pass = false;
            } elseif (strlen($param) > 50) {
                $this->messages['email'][] = "Adres mailowy nie może zawierać więcej niż 50 naków";
                $this->pass = false;
            }
        }
    }
    private function receiptRules(string $param): void
    {
        if (strlen($param) > 100) {
            $this->messages['receipt'][] = "Numer nie może byc dłuższy niż 100 znaków";
            $this->pass = false;
        }
    }

    private function objectRules(string $param): void
    {
        if (!$param) {
            $this->messages['object'][] = "Pole przedmiot zlecenia nie może być puste";
            $this->pass = false;
        } elseif (strlen($param) > 200) {
            $this->messages['object'][] = "Pole przedmiot zlecenia nie może zawierać więcej niż 200 znaków";
            $this->pass = false;
        }
    }

    private function descriptionRules(string $param): void
    {
        if (!$param) {
            $this->messages['description'][] = "Opis zlecenia jest wymagany!";
            $this->pass = false;
        } elseif (strlen($param) > 300) {
            $this->messages['description'][] = "Opis nie może zawierać więcej niż 300 znaków";
            $this->pass = false;
        }
    }

    private function termRules(string $param, string $comparisionData): void
    {
        if (!$param) {
            $this->messages['term'][] = "Pole z datą wykonania zlecenia nie może być puste";
            $this->pass = false;
        } elseif (strtotime($param) < strtotime($comparisionData)) {
            $this->messages['term'][] = "Termin zlecenia nie może być starszy niż jego utworzenie";
            $this->pass = false;
        }
    }

    //Walidacja plików:
    private function fileRules(fileController $param): void
    {
        if ($param->getFileSize()) { //jeżeli plik jest dodany to waludujemy, jeśli nie, to pomijam walidację
            $acceptedFileTypes = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx',];
            $maxFileSize = 1024; //max rozmiar pliku w KB 
            if (!(in_array($param->getFileType(), $acceptedFileTypes))) {
                $this->messages['file'][] = "Niedozwolony typ pliku. Dozwolone rozrzerzenia to: " . implode(", ", $acceptedFileTypes);
                $this->pass = false;
            } elseif ($param->getFileSize() >= $maxFileSize) {
                $this->messages['file'][] = "Maksymalny rozmiar pliku to: " . ($maxFileSize / 1024) . " MB";
                $this->pass = false;
            }
        }
    }
}
