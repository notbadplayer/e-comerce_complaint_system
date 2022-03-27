<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserSettingsModel;

class userSettingsController
{
    private UserSettingsModel $userSettingsModel;

    public function __construct(array $configuration)
    {
        $this->userSettingsModel = new UserSettingsModel($configuration);
    }

    public function getSetting(string $param)
    {
        return $this->userSettingsModel->getSetting($param);
    }

    public function getConfiguration(): array
    {
        return $this->userSettingsModel->getConfiguration();
    }

    public function saveConfiguration(array $userConfiguration): void
    {
        $this->userSettingsModel->saveConfiguration($userConfiguration);
    }
}