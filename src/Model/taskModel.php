<?php

declare(strict_types=1);

namespace App\Model;

use App\Controller\fileController;
use App\Exceptions\AppException;
use App\Model\AppModel;
use Throwable;
use PDO;

class TaskModel extends AppModel implements ModelInterface
{
    public function list(): array
    {
        try {
            $query = "SELECT id, number, customer, type, priority, status FROM current_entries";
            $entries = $this->connection->query($query);
            return $entries->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania listy zleceń');
        }
    }

    public function get(int $id): array
    {
        try {
            $query = "SELECT * FROM current_entries WHERE id=$id";
            $task = $this->connection->query($query);
            return $task->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania zlecenia');
        }
    }

    public function add(array $taskData): void
    {
        try {
            $number = $this->connection->quote($this->generateNumber());
            $created = $this->connection->quote($taskData['created']);
            $customer = $this->connection->quote($taskData['customer']);
            $receipt = $this->connection->quote($taskData['receipt']);
            $email = $this->connection->quote($taskData['email']);
            $object = $this->connection->quote($taskData['object']);
            $type = $this->connection->quote($taskData['type']);
            $priority = $this->connection->quote($taskData['priority']);
            $status = $this->connection->quote($taskData['status']);
            $term = $this->connection->quote($taskData['term']);
            $description = $this->connection->quote($taskData['description']);
            $history = $this->connection->quote(json_encode(
                array(
                    date('Y-m-d H:i:s') => [
                        'action' => 'Zarejestrowano zgłoszenie',
                        ''
                    ]
                )
            ));
            $query = "INSERT INTO current_entries (number, created, customer, receipt, email, object, type, priority, status, term, description, history) VALUES ($number, $created, $customer, $receipt, $email, $object, $type, $priority, $status, $term, $description, $history)";
            $this->connection->exec($query);

            if ($taskData['file']) { //jeżeli dodajemy plik przy nowym zleceniu to:
                $this->addFile((int) $this->connection->lastInsertId(), $taskData['file']);
            }
        } catch (Throwable $e) {
            throw new AppException('Błąd podczas dodawania nowego zlecenia');
        }
    }

    public function edit(array $taskData): void
    {
        try {
            $customer = $this->connection->quote($taskData['customer']);
            $receipt = $this->connection->quote($taskData['receipt']);
            $email = $this->connection->quote($taskData['email']);
            $object = $this->connection->quote($taskData['object']);
            $description = $this->connection->quote($taskData['description']);
            $id = $taskData['id'];

            $query = "UPDATE current_entries SET customer = $customer, receipt = $receipt, email = $email, object = $object, description = $description WHERE id = $id LIMIT 1";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy zapisywaniu zmian zlecenia.');
        }
    }

    public function delete(int $id): void
    {
        try {
            $move = "INSERT INTO archive SELECT * FROM current_entries WHERE id = $id";
            $this->connection->exec($move);
            $delete = "DELETE FROM current_entries WHERE id = $id LIMIT 1";
            $this->connection->exec($delete);
        } catch (throwable $e) {
            throw new AppException('Błąd podczas usuwania zlecenia');
        }
    }

    public function generateNumber(): ?string
    {
        try {
            $query = "SELECT number FROM current_entries ORDER BY id DESC LIMIT 1";
            $numberFromDb = $this->connection->query($query);
            $numberFromDb = $numberFromDb->fetch(PDO::FETCH_COLUMN);
            if (!($numberFromDb)) { //jeśli baza jest pusta
                $number = '1/' . date('Y');
                return $number;
                exit();
            }
            $explodedNumber = explode("/", $numberFromDb);
            if ($explodedNumber[1] != date('Y')) { //jeżeli zaczynamy nowy rok, resetujemy licznik wpisów
                $number = '1/' . date('Y');
                return $number;
                exit();
            }
            $counter = (int) $explodedNumber[0];
            $counter++;
            $number = $counter . '/' . date('Y');
            return $number;
        } catch (throwable $e) {
            throw new AppException('Błąd podczas generowania numeru zlecenia');
        }
    }

    public function changeParam(string $id, string $taskAction, string $actionMessage, string $previousValue, string $updatedValue, ?string $comment): void
    {
        try {
            $id = $this->connection->quote($id);
            $updatedValueToJson = $updatedValue; //bo jak wrzucisz zquotowaną wartość to będą podwójne apostrofy w podglądzie
            $updatedValue = $this->connection->quote($updatedValue);
            $history = $this->connection->quote(json_encode(
                array(
                    date('Y-m-d H:i:s') => [
                        'action' => $actionMessage,
                        'detail' => $previousValue . '->' . $updatedValueToJson,
                        'comment' => $comment,
                    ]
                )
            ));

            $query = "UPDATE current_entries SET $taskAction = $updatedValue, history = JSON_MERGE_PATCH(history, $history) WHERE id = $id";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy zmianie parametru zlecenia.');
        }
    }

    public function addParam(string $id, string $event, string $comment): void
    {
        try {
            $id = $this->connection->quote($id);
            $history = $this->connection->quote(json_encode(
                array(
                    date('Y-m-d H:i:s') => [
                        'action' => $event,
                        'comment' => $comment,
                    ]
                )
            ));
            $query = "UPDATE current_entries SET history = JSON_MERGE_PATCH(history, $history) WHERE id = $id";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy dodawaniu parametru zlecenia.');
        }
    }

    public function listArchive(): array
    {
        try {
            $query = "SELECT id, number, customer, type, priority, status FROM archive";
            $entries = $this->connection->query($query);
            return $entries->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania listy zleceń archiwalnych');
        }
    }

    public function getArchived(int $id): array
    {
        try {
            $query = "SELECT * FROM archive WHERE id=$id";
            $task = $this->connection->query($query);
            return $task->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania zlecenia z archiwum');
        }
    }

    public function addFile(int $id, fileController $file): void
    {
        try {
            $file->storeFile($id); //fizyczne zapisanie pliku w katalogu
            $files = $this->connection->quote(json_encode(
                array(
                    date('Y-m-d H:i:s') => [
                        'filename' => $file->getFile()['name'],
                        'location' => $file->getLocation(),
                    ]
                )
            ));
            //sprawdzamy czy jakiś plik już istnieje w bazie, jeśli nie to go dodajemy 'od zera', jeśli tak to dopisujemy do istniejących plików
            $checkQuery = "SELECT files FROM current_entries WHERE id = $id";
            $checkIfExists = $this->connection->query($checkQuery)->fetchColumn();
            if (!($checkIfExists)) {
                $query = "UPDATE current_entries SET files = $files WHERE id = $id";
                $this->connection->exec($query);
            } else {
                $query = "UPDATE current_entries SET files = JSON_MERGE_PATCH(files, $files) WHERE id = $id";
                $this->connection->exec($query);
            }
        } catch (throwable $e) {
            throw new AppException('Błąd Dodawaniu pliku do bazy danych');
        }
    }

    public function deleteFile(string $fileId, int $id): void
    {
        try {
            $query = "UPDATE current_entries SET files = JSON_REMOVE(files, '$.$fileId') WHERE id = $id";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy usuwaniu pliku z bazy danych');
        }
    }
}
//© K.Rogaczewski