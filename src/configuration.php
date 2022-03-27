<?php 
declare(strict_types=1);

namespace App;

return [
    'db' => [
      'host' => 'localhost',
      'database' => 'kazol_reklamacje',
      'user' => 'kazol_db_user',
      'password' => '123456'
    ],
    'mail' => [
      'host' => 'smtp.gmail.com',
      'SMTPAuth' => true,
      'username' => 'lubiebass@gmail.com',
      'password' => 'player1234',
      'from' => 'example@example.com'
    ]
  ];