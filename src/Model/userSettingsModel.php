<?php
declare(strict_types=1);

namespace App\Model;
use App\Exceptions\AppException;
use PDO;
use Throwable;

class UserSettingsModel extends AppModel
{
    public function getSetting(string $param){
        try {
            $query = "SELECT $param FROM user_settings";
            $result =  $this->connection->query($query)->fetchColumn();
            return (bool) $result;
        } catch (Throwable $e) {
            throw new AppException('Błąd podczas pobierania ustawień użytkownika');
        }
    }
}