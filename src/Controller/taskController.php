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
                'customer' => $this->request->postParam('customer'),
                'object' => $this->request->postParam('object'),
                'type' => $this->request->postParam('type'),
                'priority' => $this->request->postParam('priority'),
                'status' => $this->request->postParam('status'),
                'term' => $this->request->postParam('term'),
                'description' => $this->request->postParam('description'),
                'created' => date('Y-m-d'),

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
            // $this->taskModel->add($articleData);
            // header('location:/?status=added');
            // exit();
        }
        $this->view->render('add', [
            'entryNumber' => $this->taskModel->generateNumber(),
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
        $articleId = (int) $this->request->getParam('id');
        $this->view->render('edit', [
            'articleData' => $this->taskModel->get($articleId)
        ]);
    }

    public function delete(): void
    {
        $articleId = $this->request->postParam('id');
        $this->taskModel->delete((int) $articleId);
        header('location:/?status=deleted');
        exit();
    }
}