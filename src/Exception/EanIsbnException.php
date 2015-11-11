<?php

namespace Rebuy\EanIsbn\Exception;

class EanIsbnException extends \Exception
{
    /**
     * @param string $message
     * @param string[] ...$args
     */
    public function __construct($message, ...$args)
    {
        if (!empty($args)) {
            $message = sprintf($message, ...$args);
        }

        parent::__construct($message);
    }
}
