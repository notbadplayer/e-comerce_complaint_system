<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\AppException;

class TaskController extends AppController
{
    public function list(): void
    {
        $pageSize = (int) $this->request->getParam('pagesize', '50');
        $pageNumber = (int) $this->request->getParam('page', '1');

        if (!in_array($pageSize, [30, 50, 100])) {
            $pageSize = 50;
        }
        $sort = $this->sortList();
        $this->validateLogin();
        $this->view->render('list', [
            'tasks' => $this->taskModel->list($pageNumber, $pageSize, $sort),
            'status' => $this->request->getParam('status'),
            'sort' => $sort,
            'page' => [
                'number' => $pageNumber,
                'size' => $pageSize,
                'pages' => (int) ceil($this->taskModel->taskCount('current_entries') / $pageSize)
            ],
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

            //WALIDACJA P??L FORMULARZY
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
            $id = $this->taskModel->add($taskData); //dodajemy wpis i pobieramy id

            // MAILING (je??eli mail w????czony i wysy??amy po rejestracji zg??oszenia)
            if ($taskData['email'] && $this->userSetting->getSetting('enableMails') && $this->userSetting->getSetting('mail_register')) {
                $trackTask = null;
                if ($this->userSetting->getSetting('mail_link')) {
                    $trackTask = $_SERVER['SERVER_NAME'] . "?action=show&id=$id";
                }
                $logoFromDb = $this->userSetting->getSetting('logo');
                $logoToDecode = str_replace('&quot;', '"', ($logoFromDb ?? ''));
                $logoLocation = (json_Decode($logoToDecode, true) ?? [])['logo']['location'] ?? '';
                $this->mailController->registerTask($taskData, $trackTask, $logoLocation);
            }

            header('location:/?status=added');
            exit();
        }
        //PIERWSZE WEJ??CIE DO FUNKCJI, JESZCZE BEZ POBRANYCH FORMULARZY
        $this->view->render('add', [
            'entryNumber' => $this->taskModel->generateNumber(),
            'created' => date('Y-m-d'),
            'date' => date('Y-m-d', (strtotime("+" . $this->userSetting->getSetting('task_period') . "days"))),
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
            //je??li edytujemy dane, to tylko niekt??re pola, trzeba wi??c pobra?? jeszcze raz wszystkie rekordy, a potem do nich dopisa?? dane z formularza
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
                    $actionMessage = 'zmiana typu zg??oszenia';
                    break;
                case 'priority':
                    $actionMessage = 'zmiana priorytetu zg??oszenia';
                    break;
                case 'status':
                    $actionMessage = 'zmiana statusu zg??oszenia';
                    break;
                case 'term':
                    $actionMessage = 'zmiana terminu zg??oszenia';
                    break;
            }
            $id = $this->request->postParam('id');
            $this->taskModel->changeParam(
                $id,
                $taskAction,
                $actionMessage,
                $this->request->postParam('previousValue'),
                $this->request->postParam('updatedValue'),
                $this->request->postParam('comment')
            );

            // MAILING (je??eli mail w????czony i w????czony dla poszczeg??lnej akcji)
            if ($this->userSetting->getSetting('enableMails') && $this->userSetting->getSetting('mail_' . $taskAction)) {
                $taskData = $this->taskModel->get((int) $this->request->postParam('id'));
                if ($taskData['email']) { //je??eli w zg??oszeniu jest wpisany mail
                    $taskData['details'] = array(
                        'actionMessage' => $actionMessage,
                        'previousValue' =>  $this->request->postParam('previousValue'),
                        'updatedValue' =>  $this->request->postParam('updatedValue'),
                        'comment' =>  $this->request->postParam('comment'),
                    );
                    $trackTask = null;
                    if ($this->userSetting->getSetting('mail_link')) {
                        $trackTask = $_SERVER['SERVER_NAME'] . "?action=show&id=$id";
                    }
                    $logoFromDb = $this->userSetting->getSetting('logo');
                    $logoToDecode = str_replace('&quot;', '"', ($logoFromDb ?? ''));
                    $logoLocation = (json_Decode($logoToDecode, true) ?? [])['logo']['location'] ?? '';
                    $this->mailController->changeParam($taskData, $trackTask, $logoLocation);
                }
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
        $pageSize = (int) $this->request->getParam('pagesize', '50');
        $pageNumber = (int) $this->request->getParam('page', '1');

        if (!in_array($pageSize, [30, 50, 100])) {
            $pageSize = 50;
        }
        $sort = $this->sortList();
        $this->validateLogin();
        $this->view->render('archive', [
            'tasks' => $this->taskModel->listArchive($pageNumber, $pageSize, $sort),
            'sort' => $sort,
            'page' => [
                'number' => $pageNumber,
                'size' => $pageSize,
                'pages' => (int) ceil($this->taskModel->taskCount('archive') / $pageSize)
            ],
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
            if (!unlink($location)) { //fizyczne usuni??cie pliku z zasobu
                throw new AppException('B????d podczas usuwania pliku');
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
            $taskData['numOfFiles'] = $this->taskModel->checkNumOfFiles((int) $taskData['id']); //pobranie liczby plik??w dopisanych do zlecenia, z bazy danych
            $taskData['fileExists'] = $this->taskModel->checkIfFileExists($taskData['file']->getFileName(), (int) $taskData['id']); //sprawdzenie czy plik o takiej nazwie ju?? istnieje
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
            //Je??eli przeszli??my walidacj?? plik??w:
            $taskId = (int) $this->request->postParam('id');
            //je??eli wczytano plik to te?? go dodajemy
            if ($taskData['file']->getFileSize()) {
                $taskData['file']->storeFile($taskId);
                $this->taskModel->addFile($taskId, $taskData['file']); //dodanie informacji o pliku do bazy danych
            } else {
                throw new AppException('B????d podczas dodawania pliku');
            }
            $this->view->render('edit', [
                'taskData' => $this->taskModel->get($taskId),
                'status' => 'addFile'
            ]);
            exit();
        }
    }
    public function sortList(): array
    {
        $sort = [];
        $order = $this->request->getParam('order');
        if ($order) { //zabezpieczam, ??eby kto?? nie pisa?? g??upot w queryparams
            $by = $this->request->getParam('sortBy') ?? 'id';
            if (!in_array($by, ['id', 'customer', 'type', 'priority', 'status'])) {
                $by = 'id';
            }
            $order = $this->request->getParam('order') ?? '2';
            if (!in_array($order, ['1', '2'])) {
                $order = '2';
            }
            $sort = [
                'sortBy' => $by,
                'order' => $order
            ];
        };
        return $sort;
    }
}