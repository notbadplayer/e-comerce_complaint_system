<?php

declare(strict_types=1);

namespace App\Model;

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
        } catch (Throwable $e) {
            exit($e);
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
            $query = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'current_entries'";
            $number = $this->connection->query($query);
            $number = (int) $number->fetch(PDO::FETCH_COLUMN);
            $entryNumber = $number . '/' . date('Y');
            return $entryNumber;
        } catch (throwable $e) {
            throw new AppException('Błąd podczas pobierania listy wpisów');
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
}
