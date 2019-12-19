<?php

namespace com\github\nitf\newecoui\infrastructure;

use com\github\nitf\newecoui\ConfigDI;
use com\github\nitf\newecoui\repository\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function getMessage(string $key): string
    {
        return ConfigDI::message()->get($key);
    }
}