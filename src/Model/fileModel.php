<?php
declare(strict_types=1);

namespace App\Model;

use App\Controller\fileController;
use App\Exceptions\AppException;
use PDO;
use Throwable;

class FileModel extends AppModel
{
    public function storeFile(fileController $file, int $id): void
    {
        $file = $this->connection->quote(json_encode(
            array(
                $file->getFile()['name'] => [
                    'location' => $file->getLocation(),
                    'created' => date('Y-m-d H:i:s')
                ]
            )
        ));

        try {
            $query = "UPDATE current_entries SET files = JSON_MERGE_PATCH(files, $file) WHERE id = $id";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new AppException('Błąd pobierania zlecenia z archiwum');
        }
    }
}