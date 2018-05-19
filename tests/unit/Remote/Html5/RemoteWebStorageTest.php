<?php

namespace Facebook\WebDriver\Remote\Html5;

use Facebook\WebDriver\Html5\LocalStorage;
use Facebook\WebDriver\Html5\SessionStorage;
use Facebook\WebDriver\Remote\RemoteExecuteMethod;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Facebook\WebDriver\Remote\Html5\RemoteWebStorage
 */
class RemoteWebStorageTest extends TestCase
{
    /** @var RemoteExecuteMethod|\PHPUnit_Framework_MockObject_MockObject */
    private $executor;

    public function setUp()
    {
        $this->executor = $this->getMockBuilder(RemoteExecuteMethod::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testShouldReturnLocalStorage()
    {
        $storage = new RemoteWebStorage($this->executor);

        $local = $storage->getLocalStorage();
        $this->assertInstanceOf(RemoteLocalStorage::class, $local);
        $this->assertInstanceOf(LocalStorage::class, $local);
    }

    public function testShouldReturnSessionStorage()
    {
        $storage = new RemoteWebStorage($this->executor);

        $session = $storage->getSessionStorage();
        $this->assertInstanceOf(RemoteSessionStorage::class, $session);
        $this->assertInstanceOf(SessionStorage::class, $session);
    }
}
