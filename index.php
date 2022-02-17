<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

use App\Controller\TaskController;
use App\Exceptions\appException;
use App\Request;
require __DIR__ . '/vendor/autoload.php';

$request = new Request($_GET, $_POST);


try{
    (new TaskController($request))->run();
} catch(appException $e) {
    exit($e->getMessage());
}

