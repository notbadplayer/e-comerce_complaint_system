<?php
declare(strict_types=1);

namespace App\Model;

use App\Exceptions\AppException;
use PDO;
use Throwable;

class AppModel
{
    protected PDO $connection;

    public function __construct(array $configuration)
    {
        $this->validateConfig($configuration);
        $this->createConnection($configuration);
    }

    private function validateConfig($configuration): void
    {
        if (
            empty($configuration['database'])
            || empty($configuration['host'])
            || empty($configuration['user'])
            || empty($configuration['password'])
        ) {
            throw new AppException('Problem z odczytem konfiguracji');
        }
    }

    private function createConnection($configuration): void
    {
        try{
            $dsn = "mysql:dbname={$configuration['database']};host={$configuration['host']}";
            $this->connection = new PDO(
                $dsn,
                $configuration['user'],
                $configuration['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            ); 
        } catch (Throwable $e) {
            throw new AppException('Problem z połączeniem do bazy danych');
        }
    }

    public function validateLogin(string $user, string $password)
    {
        try {
            $user = $this->connection->quote($user);
            $password = $this->connection->quote($password);
            $query = "SELECT count(*) FROM users WHERE user = $user AND password = $password";
            $result = $this->connection->query($query);
            $count = $result->fetchColumn();
            if ($count>0){
                return true;
            }
            else {
                return false;
            }
        } catch (Throwable $e) {
            throw new AppException('Błąd podczas połączenia z bazą użytkowników');
        }
    }
}