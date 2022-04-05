<?php

declare(strict_types=1);

namespace App\Model;

use App\Controller\fileController;
use App\Exceptions\AppException;
use PDO;
use Throwable;

class UserSettingsModel extends AppModel
{
    public function getSetting(string $param)
    {
        try {
            $query = "SELECT $param FROM user_settings";
            $result =  $this->connection->query($query)->fetchColumn();
            return $result;
        } catch (Throwable $e) {
            throw new AppException('Błąd podczas pobierania ustawień użytkownika');
        }
    }

    public function getConfiguration(): array
    {
        try {
            $query = "SELECT * FROM user_settings";
            $task = $this->connection->query($query);
            return $task->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania konfiguracji użytkownika');
        }
    }

    public function saveConfiguration(array $userConfiguration): void
    {
        try {
            $enableMails = (int) $userConfiguration['enableMails'];
            $queryPart = "";
            //nie aktualizuję wartości, gdy enableMails ma wartość false, dlatego, że nie można odczytać wartości z pola
            //ktore jest wyłączone (bez tego nadpiszą się wszystkie nasze wartości na false)
            if ($enableMails) {
                $mail_register = (int) $userConfiguration['mail_register'];
                $mail_type = (int) $userConfiguration['mail_type'];
                $mail_priority = (int) $userConfiguration['mail_priority'];
                $mail_status = (int) $userConfiguration['mail_status'];
                $mail_term = (int) $userConfiguration['mail_term'];
                $mail_link = (int) $userConfiguration['mail_link'];
                //Może to trochę bez sensu, ale to wina boostrapa, bo on na switchu wysyła wartości "on" i NULL,
                //więc najpierw rzutuję to gówno do boola, później niestety musże to dać na inta, bo mySql 
                //nie przyjmuje wartości boolowskich

                $queryPart = ",
                mail_register = $mail_register,
                mail_type = $mail_type,
                mail_priority = $mail_priority,
                mail_status = $mail_status,
                mail_term = $mail_term,
                mail_link = $mail_link";
            }

            //część odpowiedzialna za zapis typów i statusów zleceń:
            $taskTypesString = $this->connection->quote($userConfiguration['tasks_types']);
            $statusTypesString = $this->connection->quote($userConfiguration['status_types']);
            $taskPeriod = $this->connection->quote($userConfiguration['task_period']);

            $query = "UPDATE user_settings SET 
            enableMails = $enableMails $queryPart, tasks_types =  $taskTypesString, status_types = $statusTypesString, task_period = $taskPeriod";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new AppException('Błąd podczas zapisywania konfiguracji użytkownika');
        }
    }

    public function saveLogo(fileController $file): void
    {
        try {
            $logo = $this->connection->quote(json_encode(
                array(
                    'logo' => [
                        'filename' => $file->getFileName(),
                        'location' => $file->getLocation(),
                    ]
                )
            ));
            $query = "UPDATE user_settings SET logo = $logo";
            $this->connection->exec($query);
        } catch (throwable $e) {
            throw new AppException('Błąd Dodawaniu pliku do bazy danych');
        }
    }

    public function removeLogo(): void
    {
        //najpierw usuwamy stare logo fizycznie z dysku, tutaj pobieramy o nim informacje z db
        $oldLogoQuery = "SELECT logo FROM user_settings";
        $oldLogo = $this->connection->query($oldLogoQuery);
        $oldLogo = $oldLogo->fetch(PDO::FETCH_COLUMN);

        if ($oldLogo) { //jeśli logo jest to je usuwamy
            $logoToDecode = str_replace('&quot;', '"', $oldLogo);
            $oldLogo = json_Decode($logoToDecode, true) ?? [];

            if (!unlink($oldLogo['logo']['location'])) { //fizyczne usunięcie pliku z zasobu
                throw new AppException('Błąd podczas usuwania logo');
            }
        }
    }
}