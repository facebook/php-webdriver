<?php

namespace Facebook\WebDriver\Remote\Html5;

use Facebook\WebDriver\Html5\LocalStorage;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\RemoteExecuteMethod;

/**
 * Executes the commands to access HTML5 localStorage on the remote webdriver server.
 */
class RemoteLocalStorage implements LocalStorage
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
        $this->executor->execute(DriverCommand::CLEAR_LOCAL_STORAGE);
    }

    /**
     * @inheritDoc
     */
    public function getItem($key)
    {
        return $this->executor->execute(DriverCommand::GET_LOCAL_STORAGE_ITEM, [
            ':key' => $key,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function keySet()
    {
        return $this->executor->execute(DriverCommand::GET_LOCAL_STORAGE_KEYS);
    }

    /**
     * @inheritDoc
     */
    public function removeItem($key)
    {
        $this->executor->execute(DriverCommand::REMOVE_LOCAL_STORAGE_ITEM, [
            ':key' => $key,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function setItem($key, $value)
    {
        $this->executor->execute(DriverCommand::SET_LOCAL_STORAGE_ITEM, [
            'key' => $key,
            'value' => $value,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function size()
    {
        return $this->executor->execute(DriverCommand::GET_LOCAL_STORAGE_SIZE);
    }
}
