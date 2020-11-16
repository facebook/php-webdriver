<?php

namespace Facebook\WebDriver\Chrome;

use PHPUnit\Framework\TestCase;

/**
 * @group exclude-saucelabs
 * @covers \Facebook\WebDriver\Chrome\ChromeDriverService
 * @covers \Facebook\WebDriver\Remote\Service\DriverService
 */
class ChromeDriverServiceTest extends TestCase
{
    protected function setUp(): void
    {
        if (!getenv('BROWSER_NAME') === 'chrome' || getenv('SAUCELABS') || !getenv('CHROMEDRIVER_PATH')) {
            $this->markTestSkipped('ChromeDriverServiceTest is run only when running against local chrome');
        }
    }

    public function testShouldStartAndStopServiceCreatedUsingShortcutConstructor()
    {
        // The createDefaultService() method expect path to the executable to be present in the environment variable
        putenv(ChromeDriverService::CHROME_DRIVER_EXECUTABLE . '=' . getenv('CHROMEDRIVER_PATH'));

        $driverService = ChromeDriverService::createDefaultService();

        $this->assertSame('http://localhost:9515', $driverService->getURL());

        $this->assertInstanceOf(ChromeDriverService::class, $driverService->start());
        $this->assertTrue($driverService->isRunning());

        $this->assertInstanceOf(ChromeDriverService::class, $driverService->start());

        $this->assertInstanceOf(ChromeDriverService::class, $driverService->stop());
        $this->assertFalse($driverService->isRunning());

        $this->assertInstanceOf(ChromeDriverService::class, $driverService->stop());
    }

    public function testShouldStartAndStopServiceCreatedUsingDefaultConstructor()
    {
        $driverService = new ChromeDriverService(getenv('CHROMEDRIVER_PATH'), 9515, ['--port=9515']);

        $this->assertSame('http://localhost:9515', $driverService->getURL());

        $driverService->start();
        $this->assertTrue($driverService->isRunning());

        $driverService->stop();
        $this->assertFalse($driverService->isRunning());
    }

    public function testShouldThrowExceptionIfExecutableCannotBeFound()
    {
        putenv(ChromeDriverService::CHROME_DRIVER_EXECUTABLE . '=/not/existing');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('\'/not/existing\' is not a file.');
        ChromeDriverService::createDefaultService();
    }

    public function testShouldThrowExceptionIfExecutableIsNotExecutable()
    {
        putenv(ChromeDriverService::CHROME_DRIVER_EXECUTABLE . '=' . __FILE__);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('is not executable');
        ChromeDriverService::createDefaultService();
    }
}
