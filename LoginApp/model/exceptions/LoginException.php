<?php

namespace Model;

class LoginException extends \Exception
{
}

class WrongUsernameOrPasswordException extends LoginException
{
}
