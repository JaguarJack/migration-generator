<?php

namespace JaguarJack\MigrateGenerator\Exceptions;

class EmptyInDatabaseException extends \Exception
{
    protected $message = 'database has no table';
}
