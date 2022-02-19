<?php

declare(strict_types=1);

namespace App\Controller;

class TaskController extends AppController
{
    public function list(): void
    {
        $this->view->render('list', [
            'tasks' => $this->taskModel->list(),
            'status' => $this->request->getParam('status'),
        ]);
    }

    public function show(): void
    {
        $articleId = (int) $this->request->getParam('id');
        $this->view->render('show', [
            'article' => $this->taskModel->get($articleId),
        ]);
    }

    public function add(): void
    {
        if ($this->request->hasPost()) {
            $taskData = [
                'created' => date('Y-m-d'),
                'customer' => $this->request->postParam('customer'),
                'receipt' => $this->request->postParam('receipt'),
                'customerEmail' => $this->request->postParam('customerEmail'),
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
        if ($this->request->hasPost()) {
            $articleData = [
                'title' => $this->request->postParam('title'),
                'content' => $this->request->postParam('content'),
                'status' => $this->request->postParam('status'),
                'category' => $this->request->postParam('category'),
                'id' => $this->request->postParam('id')
            ];
            $validatedArticle = $this->validator->validate($articleData);
            if (!$validatedArticle['pass']) {
                $this->view->render('edit', [
                    'articleData' =>  $articleData,
                    'messages' => $validatedArticle['messages']
                ]);
                exit();
            }
            $this->taskModel->edit($articleData);
            header('location:/?status=edited');
            exit();
        }
        $taskId = (int) $this->request->getParam('id');
        $this->view->render('edit', [
            'taskData' => $this->taskModel->get($taskId)
        ]);
    }

    public function delete(): void
    {
        $articleId = $this->request->postParam('id');
        $this->taskModel->delete((int) $articleId);
        header('location:/?status=deleted');
        exit();
    }

    public function changeParam()
    {
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

            if ($taskAction === 'term') {
                $validatedTerm = $this->validator->validateTermOnly($this->request->postParam('updatedValue'), $this->request->postParam('previousValue'));
                if (!$validatedTerm['pass']) { 
                    header("location:javascript://history.go(-1)");
                    exit();
                }
            }

            $this->taskModel->changeParam(
                $this->request->postParam('id'),
                $taskAction,
                $actionMessage,
                $this->request->postParam('previousValue'),
                $this->request->postParam('updatedValue'),
                $this->request->postParam('comment')
            );
            header('location:/?status=edited');
            exit();
        }
    }
}
