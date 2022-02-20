<?php

declare(strict_types=1);

namespace App\Controller;

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
                'status' => 'Przyjęte',
                'term' => $this->request->postParam('term'),
                'description' => $this->request->postParam('description'),
            ];
            $validatedTask = $this->validator->validate($taskData);
            if (!$validatedTask['pass']) {
                $this->view->render('add', [
                    'entryNumber' => $this->taskModel->generateNumber(),
                    'date' => $taskData['term'],
                    'taskData' =>  $taskData,
                    'messages' => $validatedTask['messages']
                ]);
                exit();
            }
            $this->taskModel->add($taskData);
            header('location:/?status=added');
            exit();
        }
        $this->view->render('add', [
            'entryNumber' => $this->taskModel->generateNumber(),
            'created' => date('Y-m-d'),
            'date' => date('Y-m-d', (strtotime("+1 week"))),
        ]);
    }

    public function edit(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            $taskId = (int) $this->request->postParam('id');
            $taskData= $this->taskModel->get($taskId);
            //jeśli edytujemy dane, to tylko niektóre pola, trzeba więc pobrać jeszcze raz wszystkie rekordy, a potem do nich dopisać dane z formularza
            $taskData ['customer'] = $this->request->postParam('customer');
            $taskData ['receipt'] = $this->request->postParam('receipt');
            $taskData ['email'] = $this->request->postParam('customerEmail');
            $taskData ['object'] = $this->request->postParam('object');
            $taskData ['description'] = $this->request->postParam('description');
            $taskData ['id'] = $taskId;

            $validatedTask = $this->validator->validate($taskData);
            if (!$validatedTask['pass']) {
                $this->view->render('edit', [
                    'entryNumber' => $this->taskModel->generateNumber(),
                    'date' => $taskData['term'],
                    'taskData' =>  $taskData,
                    'messages' => $validatedTask['messages']
                ]);
                exit();
            }
            $this->taskModel->edit($taskData);
            header("location:/?action=edit&id=".$taskId."&status=edited");
            exit();
        }
        $taskId = (int) $this->request->getParam('id');
        $taskData= $this->taskModel->get($taskId);
        $this->view->render('edit', [
            'taskData' => $taskData,
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
            header("location:/?action=edit&id=".$this->request->postParam('id')."&status=paramChanged");
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
            header("location:/?action=edit&id=".$this->request->postParam('id')."&status=paramAdded");
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
}