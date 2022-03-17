<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\TaskModel;
use App\Request;
use App\Validate;
use App\View\View;
use App\Controller\mailController;
use App\Model\UserSettingsModel;

session_start();

abstract class AppController
{
    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    protected Request $request;
    protected View $view;
    protected TaskModel $taskModel;
    protected Validate $validator;
    protected fileController $fileController;
    protected MailController $mailController;
    protected userSettingsController $userSetting;
    protected UserSettingsModel $userSettingsModel;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
        self::$configuration = require_once('src/configuration.php');
        $this->taskModel = new TaskModel(self::$configuration['db']);
        $this->validator = new Validate();
        $this->mailController = new MailController(self::$configuration['mail']);
        $this->userSetting = new userSettingsController(self::$configuration['db']);
    }

    public function run(): void
    {
        $action = $this->getAction();
        $this->$action();
    }

    private function getAction(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    protected function validateLogin(): void
    {
        if (!isset($_SESSION['login'])) {
            $this->view->login();
            exit();
        }
    }

    public function login()
    {
        if ($this->request->hasPost()) {
            $validatedUser = $this->taskModel->validateLogin($this->request->postParam('username'), $this->request->postParam('password'));
            if ($validatedUser) {
                $_SESSION['login'] = $this->request->postParam('username');
                header("location:/");
                exit();
            } else {
                $this->view->login('Nieprawidłowa nazwa użytkownika lub hasło.');
            exit();
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("location:/");
        exit();
    }
}
//© K.Rogaczewski