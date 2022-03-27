<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\AppException;

class TaskController extends AppController
{
    public function list(): void
    {
        $this->validateLogin();
        $this->view->render('list', [
            'tasks' => $this->taskModel->list(),
            'status' => $this->request->getParam('status'),
        ]);
    }

    public function show(): void
    {
        $taskId = (int) $this->request->getParam('id');
        $this->view->render('show', [
            'taskData' => $this->taskModel->get($taskId),
        ]);
    }

    public function add(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            $taskData = [
                'created' => date('Y-m-d'),
                'customer' => $this->request->postParam('customer'),
                'receipt' => $this->request->postParam('receipt'),
                'email' => $this->request->postParam('customerEmail'),
                'object' => $this->request->postParam('object'),
                'type' => $this->request->postParam('type'),
                'priority' => $this->request->postParam('priority'),
                'status' => $this->request->postParam('status'),
                'term' => $this->request->postParam('term'),
                'description' => $this->request->postParam('description'),
                'file' => new fileController($_FILES['file']), //pobieramy plik z formularza i wrzucamy do oddzielnego kontrolera 
            ];

            //WALIDACJA PÓL FORMULARZY
            $validatedTask = $this->validator->validate($taskData);
            if (!$validatedTask['pass']) {
                $this->view->render('add', [
                    'entryNumber' => $this->taskModel->generateNumber(),
                    'date' => $taskData['term'],
                    'created' => date('Y-m-d'),
                    'types' =>  explode(';', $this->userSetting->getSetting('tasks_types')),
                    'statuses' =>  explode(';', $this->userSetting->getSetting('status_types')),
                    'taskData' =>  $taskData,
                    'messages' => $validatedTask['messages']
                ]);
                exit();
            }
            if (!($taskData['file']->getFileSize())) {
                $taskData['file'] = null;
            }
            $this->taskModel->add($taskData); //dodajemy wpis

            // MAILING (jeżeli mail włączony i wysyłamy po rejestracji zgłoszenia)
            if ($this->userSetting->getSetting('enableMails') && $this->userSetting->getSetting('mail_register')) {
                $taskData['entryNumber'] = $this->taskModel->generateNumber();
                $this->mailController->registerTask($taskData);
            }

            header('location:/?status=added');
            exit();
        }
        //PIERWSZE WEJŚCIE DO FUNKCJI, JESZCZE BEZ POBRANYCH FORMULARZY
        $this->view->render('add', [
            'entryNumber' => $this->taskModel->generateNumber(),
            'created' => date('Y-m-d'),
            'date' => date('Y-m-d', (strtotime("+1 week"))),
            'types' =>  explode(';', $this->userSetting->getSetting('tasks_types')),
            'statuses' =>  explode(';', $this->userSetting->getSetting('status_types')),
        ]);
    }

    public function edit(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            $taskId = (int) $this->request->postParam('id');
            $taskData = $this->taskModel->get($taskId);
            //jeśli edytujemy dane, to tylko niektóre pola, trzeba więc pobrać jeszcze raz wszystkie rekordy, a potem do nich dopisać dane z formularza
            $taskData['customer'] = $this->request->postParam('customer');
            $taskData['receipt'] = $this->request->postParam('receipt');
            $taskData['email'] = $this->request->postParam('customerEmail');
            $taskData['object'] = $this->request->postParam('object');
            $taskData['description'] = $this->request->postParam('description');
            $taskData['id'] = $taskId;

            $validatedTask = $this->validator->validate($taskData);
            if (!$validatedTask['pass']) {
                $this->view->render('edit', [
                    'entryNumber' => $this->taskModel->generateNumber(),
                    'date' => $taskData['term'],
                    'taskData' =>  $taskData,
                    'types' =>  explode(';', $this->userSetting->getSetting('tasks_types')),
                    'statuses' =>  explode(';', $this->userSetting->getSetting('status_types')),
                    'messages' => $validatedTask['messages']
                ]);
                exit();
            }
            $this->taskModel->edit($taskData);
            header("location:/?action=edit&id=" . $taskId . "&status=edited");
            exit();
        }
        $taskId = (int) $this->request->getParam('id');
        $taskData = $this->taskModel->get($taskId);
        $this->view->render('edit', [
            'taskData' => $taskData,
            'types' =>  explode(';', $this->userSetting->getSetting('tasks_types')),
            'statuses' =>  explode(';', $this->userSetting->getSetting('status_types')),
            'status' => $this->request->getParam('status'),
        ]);
    }

    public function delete(): void
    {
        $this->validateLogin();
        $taskId = $this->request->postParam('id');
        $this->taskModel->delete((int) $taskId);
        header('location:/?status=archived');
        exit();
    }

    public function changeParam(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            $taskAction = $this->request->postParam('taskAction');
            $actionMessage = '';
            switch ($taskAction) {
                case 'type':
                    $actionMessage = 'zmiana typu zgłoszenia';
                    break;
                case 'priority':
                    $actionMessage = 'zmiana priorytetu zgłoszenia';
                    break;
                case 'status':
                    $actionMessage = 'zmiana statusu zgłoszenia';
                    break;
                case 'term':
                    $actionMessage = 'zmiana terminu zgłoszenia';
                    break;
            }

            $this->taskModel->changeParam(
                $this->request->postParam('id'),
                $taskAction,
                $actionMessage,
                $this->request->postParam('previousValue'),
                $this->request->postParam('updatedValue'),
                $this->request->postParam('comment')
            );

            // MAILING (jeżeli mail włączony i włączony dla poszczególnej akcji)
            if ($this->userSetting->getSetting('enableMails') && $this->userSetting->getSetting('mail_' . $taskAction)) {
                $taskData = $this->taskModel->get((int) $this->request->postParam('id'));
                $taskData['details'] = array(
                    'actionMessage' => $actionMessage,
                    'previousValue' =>  $this->request->postParam('previousValue'),
                    'updatedValue' =>  $this->request->postParam('updatedValue'),
                    'comment' =>  $this->request->postParam('comment'),
                );
                $this->mailController->changeParam($taskData);
            }

            header("location:/?action=edit&id=" . $this->request->postParam('id') . "&status=paramChanged");
            exit();
        }
    }

    public function addParam(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            $this->taskModel->addParam(
                $this->request->postParam('id'),
                $this->request->postParam('event'),
                $this->request->postParam('comment')
            );
            header("location:/?action=edit&id=" . $this->request->postParam('id') . "&status=paramAdded");
            exit();
        }
    }

    public function listArchive(): void
    {
        $this->validateLogin();
        $this->view->render('archive', [
            'tasks' => $this->taskModel->listArchive(),
        ]);
    }

    public function showArchived(): void
    {
        $this->validateLogin();
        $taskId = (int) $this->request->getParam('id');
        $this->view->render('show', [
            'taskData' => $this->taskModel->getArchived($taskId),
        ]);
    }

    public function deleteFile(): void
    {
        if ($this->request->hasPost()) {
            $taskId = (int) $this->request->postParam('id');
            $fileId = $this->request->postParam('fileId');
            $location = $this->request->postParam('location');

            $this->taskModel->deleteFile($fileId, $taskId); //wyrzucenie wpisu z bazy danych
            if (!unlink($location)) { //fizyczne usunięcie pliku z zasobu
                throw new AppException('Błąd podczas usuwania pliku');
            }

            $this->view->render('edit', [
                'taskData' => $this->taskModel->get($taskId),
                'status' => 'deletedFile'
            ]);
            exit();
        }
    }

    public function addFile(): void
    {
        if ($this->request->hasPost()) {
            $taskData['file'] = new fileController($_FILES['file']); //pobieramy plik z formularza i wrzucamy do oddzielnego kontrolera 
            $taskData['id'] = $this->request->postParam('id');
            $taskData['numOfFiles'] = $this->taskModel->checkNumOfFiles((int) $taskData['id']); //pobranie liczby plików dopisanych do zlecenia, z bazy danych
            $taskData['fileExists'] = $this->taskModel->checkIfFileExists($taskData['file']->getFileName(), (int) $taskData['id']); //sprawdzenie czy plik o takiej nazwie już istnieje
            $validatedFile = $this->validator->validate($taskData);
            if (!$validatedFile['pass']) {
                $taskId = (int) $this->request->postParam('id');
                $taskData = $this->taskModel->get($taskId);
                $this->view->render('edit', [
                    'taskData' => $taskData,
                    'status' => 'fileAddError',
                    'messages' => $validatedFile['messages']
                ]);
                exit();
            }
            //Jeżeli przeszliśmy walidację plików:
            $taskId = (int) $this->request->postParam('id');
            //jeżeli wczytano plik to też go dodajemy
            if ($taskData['file']->getFileSize()) {
                $taskData['file']->storeFile($taskId);
                $this->taskModel->addFile($taskId, $taskData['file']); //dodanie informacji o pliku do bazy danych
            } else {
                throw new AppException('Błąd podczas dodawania pliku');
            }
            $this->view->render('edit', [
                'taskData' => $this->taskModel->get($taskId),
                'status' => 'addFile'
            ]);
            exit();
        }
    }
}
