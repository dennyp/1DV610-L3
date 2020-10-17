<?php

namespace View;

class LoginCredentialsExceptions extends \Exception
{
}

class MissingUsernameException extends LoginCredentialsExceptions
{
}

class MissingPasswordException extends LoginCredentialsExceptions
{
}
