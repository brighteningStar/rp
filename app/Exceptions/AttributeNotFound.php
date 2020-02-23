<?php


namespace App\Exceptions;

use Exception;
use Throwable;

class AttributeNotFound extends Exception
{
    protected $message;
    protected $code;

    public function __construct( $message = "", $code = 0, Throwable $previous = null )
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct( $message, $code, $previous );
    }

    public function render($request)
    {
        return response()->json(['file' => $this->message], $this->code);
    }
}
