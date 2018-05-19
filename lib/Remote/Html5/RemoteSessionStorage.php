<?php

namespace Facebook\WebDriver\Remote\Html5;

use Facebook\WebDriver\Html5\SessionStorage;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\RemoteExecuteMethod;

/**
 * Executes the commands to access HTML5 sessionStorage on the remote webdriver server.
 */
class RemoteSessionStorage implements SessionStorage
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

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->executor->execute(DriverCommand::CLEAR_SESSION_STORAGE);
    }

    /**
     * @inheritDoc
     */
    public function getItem($key)
    {
        return $this->executor->execute(DriverCommand::GET_SESSION_STORAGE_ITEM, [
            ':key' => $key,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function keySet()
    {
        return $this->executor->execute(DriverCommand::GET_SESSION_STORAGE_KEYS);
    }

    /**
     * @inheritDoc
     */
    public function removeItem($key)
    {
        $this->executor->execute(DriverCommand::REMOVE_SESSION_STORAGE_ITEM, [
            ':key' => $key,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function setItem($key, $value)
    {
        $this->executor->execute(DriverCommand::SET_SESSION_STORAGE_ITEM, [
            'key' => $key,
            'value' => $value,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function size()
    {
        return $this->executor->execute(DriverCommand::GET_SESSION_STORAGE_SIZE);
    }
}
