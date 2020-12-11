<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    private $processors = [];

    public function __construct($actionsNotSet = [], $actionsSet = [])
    {
        $this->processActions($actionsNotSet, $actionsSet);
    }

    private function processActions($actionsNotSet, $actionsSet)
    {
        $user = Application::$app->session->get('user');

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
