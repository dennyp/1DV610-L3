<?php

namespace Model;

class Cookie
{

    private $name;
    private $value;
    private $time;

    public function __construct($name, $value, $time)
    {
        $this->name = $name;
        $this->value = $value;
        $this->time = $time;
        $this->setCookie();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getCookie()
    {
        return $_COOKIE[$this->getName()];
    }

    public function setCookie()
    {
        return \setcookie($this->getName(), $this->getValue(), $this->getTime());
    }

    public function delete()
    {
        return \setcookie($this->getName(), '', time() - 3600);
    }

}
