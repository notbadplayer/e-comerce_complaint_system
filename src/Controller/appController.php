<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\TaskModel;
use App\Request;
use App\Validate;
use App\View\View;
use App\Controller\mailController;
use App\Exceptions\AppException;
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
    protected array $userConfiguration;

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
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION;
        }
        $this->$action();
    }

    private function getAction(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    private function changeUserSettings(): void
    {
        $this->validateLogin();
        if ($this->request->hasPost()) {
            //logika przypisania typów 
            $task_types = '';
            for ($i = 0; $i < 5; $i++) { //docelowo będę pobierał liczbę dopuszcalnych typów z konfiguracji
                if ($this->request->postParam("task_type_$i")) {
                    $task_types = $task_types . ";" . preg_replace('/[^A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ0-9\-\s]/', '', $this->request->postParam("task_type_$i"));
                }
            }
            $task_types = trim($task_types, ';'); //usuwam ostatni separator
            $status_types = '';
            for ($i = 0; $i < 5; $i++) { //docelowo będę pobierał liczbę dopuszcalnych typów z konfiguracji
                if ($this->request->postParam("status_type_$i")) {
                    $status_types = $status_types . ";" . preg_replace('/[^A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ0-9\-\s]/', '', $this->request->postParam("status_type_$i"));
                }
            }
            $status_types = trim($status_types, ';'); //usuwam ostatni separator

            $userConfiguration = [
                'enableMails' => $this->request->postParam('enableMails'),
                'mail_register' => $this->request->postParam('mail_register'),
                'mail_type' => $this->request->postParam('mail_type'),
                'mail_priority' => $this->request->postParam('mail_priority'),
                'mail_status' => $this->request->postParam('mail_status'),
                'mail_term' =>  $this->request->postParam('mail_term'),
                'mail_link' =>  $this->request->postParam('mail_link'),
                'tasks_types' => $task_types,
                'status_types' => $status_types,
                'task_period' => $this->request->postParam('taskPeriod'),
                'logo' => new fileController($_FILES['logo']), //pobieramy plik z formularza i wrzucamy do oddzielnego kontrolera 
            ];

            $validatedConfiguration = $this->validator->validate($userConfiguration);

            if (!$validatedConfiguration['pass']) {
                $this->view->render('userConfiguration', [
                    'userConfiguration' => $userConfiguration,
                    'status' => 'configEditError',
                    'messages' => $validatedConfiguration['messages']
                ]);
                exit();
            }
            //Zapisywanie logo:
            if ($userConfiguration['logo']->getFileSize()) {
                $this->userSetting->removeLogo(); //sunięcie starego logo
                $userConfiguration['logo']->storeFile('logo'); //fizyczne zapisanie logo na dysku
                $this->userSetting->saveLogo($userConfiguration['logo']); //dodanie informacji o pliku do bazy danych

            }
            //zapis całej konfiguracji (logo zapisaliśmy wcześniej)
            $this->userSetting->saveConfiguration($userConfiguration);
            $this->view->render('userConfiguration', [
                'userConfiguration' => $this->userSetting->getConfiguration(),
                'status' => 'configModified',
            ]);
            exit();
        }
        //pierwsze wejście do funkcji
        $this->view->render('userConfiguration', [
            'userConfiguration' => $this->userSetting->getConfiguration(),
            'status' => $this->request->getParam('status'),
        ]);
    }

    protected function getLogo(): string
    {
        $logoFromDb = $this->userSetting->getSetting('logo');
        $logoToDecode = str_replace('&quot;', '"', ($logoFromDb ?? ''));
        $logoLocation = (json_Decode($logoToDecode, true) ?? [])['logo']['location'] ?? '';
        return $logoLocation;
    }

    protected function validateLogin(): void
    {
        if (!isset($_SESSION['login'])) {

            $this->view->login(null, $this->getLogo());
            exit();
        }
    }

    protected function login(): void
    {
        if ($this->request->hasPost()) {
            $validatedUser = $this->taskModel->validateLogin($this->request->postParam('username'), $this->request->postParam('password'));
            if ($validatedUser) {
                $_SESSION['login'] = $this->request->postParam('username');
                header("location:/");
                exit();
            } else {
                $this->view->login('Nieprawidłowa nazwa użytkownika lub hasło.', $this->getLogo());
                exit();
            }
        }
    }

    public function logout(): void
    {
        session_destroy();
        header("location:/");
        exit();
    }
}
//© K.Rogaczewski