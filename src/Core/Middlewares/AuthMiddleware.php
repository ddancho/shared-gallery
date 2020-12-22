<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    private $processors = [];

    public function __construct($actionsNotSet = [], $actionsSet = [], $cookieCheck = false)
    {
        $this->processActions($actionsNotSet, $actionsSet, $cookieCheck);
    }

    private function processActions($actionsNotSet, $actionsSet, $cookieCheck)
    {
        $user = Application::$app->session->get('user');

        if ($cookieCheck && $user !== null) {
            return \header('Location: ' . Application::$base . '/gallery');
        } else if ($cookieCheck && !empty($_COOKIE['rememberMe'])) {
            return \header('Location: ' . Application::$base . '/login');
        } else {

            if (!empty($actionsNotSet)) {
                $requirement = $this->getRequirementForActions($user, null);

                $this->processors[] = [
                    $requirement => $actionsNotSet,
                ];
            }

            if (!empty($actionsSet)) {
                $requirement = $this->getRequirementForActions($user, true);

                $this->processors[] = [
                    $requirement => $actionsSet,
                ];
            }

            if (empty($actionsNotSet) && empty($actionsSet)) {
                $requirement = $this->getRequirementForActions($user, null);

                $this->processors[] = [
                    $requirement => '',
                ];
            }
        }
    }

    private function getRequirementForActions($user, $requirement)
    {
        if ($requirement === null) {
            return $user === null ? true : false;
        } else {
            return $user !== null ? true : false;
        }
    }

    public function execute()
    {
        foreach ($this->processors as $processor) {
            foreach ($processor as $requirement => $actions) {
                if ($requirement) {
                    if (empty($actions) || \in_array(Application::$app->router->controller->action, $actions)) {
                        throw new ForbiddenException();
                    }
                }
            }
        }
    }
}
