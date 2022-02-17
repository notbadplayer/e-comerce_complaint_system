<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\TaskModel;
use App\Request;
use App\Validate;
use App\View\View;

abstract class AppController
{
    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    protected Request $request;
    protected View $view;
    protected TaskModel $taskModel;
    protected Validate $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
        self::$configuration = require_once('src/configuration.php');
        $this->taskModel = new TaskModel(self::$configuration['db']);
        $this->validator = new Validate();
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
}