<?php
declare(strict_types=1);

namespace App\View;

class View
{
    public function render(string $page, array $params = []): void
    {
        $params = $this->escape($params);
        require_once('templates/layout.php');
    }

    private function escape(array $params): array
    {
        $escapedParams = [];
        foreach($params as $key => $value){
            if(is_array($value)){
                $escapedParams[$key] =$this->escape($value);
            } elseif (is_int($value) || is_null($value)) {
                $escapedParams[$key] = $value;
            } elseif (is_string($value)) {
                $escapedParams[$key] = htmlentities($value);
            } else {
                $escapedParams[$key] = ($value);
            }
        }
        return $escapedParams;
    }

    public function login(string $error = null, string $logoLocation): void
    {
        require_once('templates/pages/login.php');
    }
}