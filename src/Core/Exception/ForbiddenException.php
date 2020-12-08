<?php

namespace App\Core\Exception;

class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = 'You don\'t have permisson to access this page';
}
