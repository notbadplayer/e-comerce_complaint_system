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
            $customer = $this->connection->quote($taskData['customer']);
            $object = $this->connection->quote($taskData['object']);
            $type = $this->connection->quote($taskData['type']);
            $priority = $this->connection->quote($taskData['priority']);
            $status = $this->connection->quote($taskData['status']);
            $term = $this->connection->quote($taskData['term']);
            $description = $this->connection->quote($taskData['description']);
            $age = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
            $history = $this->connection->quote(json_encode(
                array(
                    date('Y-m-d H:i:s') => [
                        'action' => 'Zarejestrowano zgłoszenie',
                        ''
                    ]
                )
            ));

            $query = "INSERT INTO current_entries (number, customer, object, type, priority, status, term, description, historia) VALUES ($number, $customer, $object, $type, $priority, $status, $term, $description, $history)";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            exit($e);
            throw new AppException('Błąd podczas dodawania nowego zlecenia');
        }
    }

    public function edit(array $articleData): void
    {
        try {
            $title = $this->connection->quote($articleData['title']);
            $content = $this->connection->quote($articleData['content']);
            $status = $this->connection->quote($articleData['status']);
            $category = $this->connection->quote($articleData['category']);
            $id = $articleData['id'];

            $query = "UPDATE articles SET title = $title, content = $content, status = $status, category = $category WHERE id = $id LIMIT 1";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy zapisywaniu zmian w artykule.');
        }
    }

    public function delete(int $id): void
    {
        try {
            $query = "DELETE FROM articles WHERE id = $id LIMIT 1";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd podczas usuwania artykułu');
        }
    }

    public function generateNumber(): ?string
    {
        try {
            $query = "SELECT MAX(id) FROM current_entries";
            $number = $this->connection->query($query);
            $number = (int) $number->fetch(PDO::FETCH_COLUMN);
            $number++;
            $entryNumber = $number . '/' . date('Y');
            return $entryNumber;
        } catch (throwable $e) {
            throw new AppException('Błąd podczas pobierania listy wpisów');
        }
    }

    public function changeParam(string $id, string $taskAction, string $actionMessage, string $previousValue, string $updatedValue, ?string $comment)
    {
        try {
            $id = $this->connection->quote($id);
            $updatedValueToJson = $updatedValue; //bo jak wrzucisz zqotowaną wartość to będą podwójne apostrofy w podglądzie
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

            $query = "UPDATE current_entries SET $taskAction = $updatedValue, historia = JSON_MERGE_PATCH(historia, $history) WHERE id = $id";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd przy zmianie parametru wpisu.');
        }

    }
}
