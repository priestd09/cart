<?php

namespace Recca0120\Cart;

use Closure;
use Illuminate\Support\Fluent;
use Recca0120\Cart\Contracts\Cart as CartContract;
use Recca0120\Cart\Contracts\Fee as FeeContract;

class Fee extends Fluent implements FeeContract
{
    use SerializeHandler;

    public function __construct($code, $description, Closure $handler = null)
    {
        $this
            ->setCode($code)
            ->setDescription($description)
            ->setHandler($handler);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function defaultHandler(CartContract $cart)
    {
        return 0;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setHandler(Closure $handler = null)
    {
        $this->handler = is_null($handler) === false ? $handler : [$this, 'defaultHandler'];

        return $this;
    }

    public function apply(CartContract $cart)
    {
        return call_user_func($this->getHandler(), $cart);
    }
}