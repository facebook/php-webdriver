<?php

namespace Facebook\WebDriver\Remote\Html5;

use Facebook\WebDriver\Html5\WebStorage;
use Facebook\WebDriver\Remote\RemoteExecuteMethod;

/**
 * Provides remote access to the WebStorage API.
 */
class RemoteWebStorage implements WebStorage
{
    /**
     * @var RemoteExecuteMethod
     */
    private $executor;

    /**
     * @param RemoteExecuteMethod $executor
     */
    public function __construct(RemoteExecuteMethod $executor)
    {
        $this->executor = $executor;
    }

    public function getLocalStorage()
    {
        return new RemoteLocalStorage($this->executor);
    }

    public function getSessionStorage()
    {
        return new RemoteSessionStorage($this->executor);
    }
}
