<?php

namespace com\github\nitf\newecoui\repository;

interface MessageRepositoryInterface
{
    /**
     * @param string $key
     * @return string
     */
    public function getMessage(string $key): string;
}