php-webdriver -- A very thin wrapper of WebDriver
=================================================

##  DESCRIPTION

This client aims to be as thin as possible, abusing the dynamic nature of PHP to allow almost all API calls to be a direct transformation of what is defined in the WebDriver protocol itself.

Most clients require you to first read the protocol to see what's possible, then study the client itself to see how to call it.  This hopes to eliminate the latter step, and invites you to rely almost exclusively on http://code.google.com/p/selenium/wiki/JsonWireProtocol

Each command is just the name of a function call, and each additional path is just another chained function call.  The function parameter is then either an array() if the command takes JSON parameters, or an individual primitive if it takes a URL parameter.

The function's return value is exactly what is returned from the server as part of the protocol definition.  If an error is returned, the function will throw the appropriate WebDriverException instance.

##  INSTALLATION

Through PEAR installer

    $ pear install -f package.xml

##  GETTING STARTED

*   All you need as the server for this client is the selenium-server-standalone-#.jar file provided here:  http://code.google.com/p/selenium/downloads/list

*   Download and run that file, replacing # with the current server version.

        java -jar selenium-server-standalone-#.jar

*   Then when you create a session, be sure to pass the url to where your server is running.

        // This would be the url of the host running the server-standalone.jar
        $wd_host = 'http://localhost:4444/wd/hub'; // this is the default
        $web_driver = new WebDriver($wd_host);

        // First param to session() is the 'browserName' (default = 'firefox')
        // Second param is a JSON object of additional 'desiredCapabilities'

        // POST /session
        $session = $web_driver->session('firefox');

* See also [wiki page for launching different browsers](https://github.com/facebook/php-webdriver/wiki/Launching-Browsers).

##  SIMPLE EXAMPLES

### Note that all of these match the Protocol exactly
*   Move to a specific spot on the screen

        // POST /session/:sessionId/moveto
        $session->moveto(array('xoffset' => 3, 'yoffset' => 300));

*   Get the current url

        // GET /session/:sessionId/url
        $session->url();

*   Change focus to another frame

        // POST /session/:sessionId/frame
        $session->frame(array('id' => 'some_frame_id'));

*   Get a list of window handles for all open windows

        // GET /session/:sessionId/window_handles
        $session->window_handles();

*   Accept the currently displayed alert dialog

        // POST /session/:sessionId/accept_alert
        $session->accept_alert();

*   Change asynchronous script timeout

        // POST /session/:sessionId/timeouts/async_script
        $session->timeouts()->async_script(array('ms' => 2000));

*   Doubleclick an element on a touch screen

        // POST session/:sessionId/touch/doubleclick
        $session->touch()->doubleclick(array('element' => $element->getID())

*   Check if two elements are equal

        // GET /session/:sessionId/element/:id/equals/:other
        $element->equals($other_element->getID()))

*   Get value of a css property on element

        // GET /session/:sessionId/element/:id/css/:propertyName
        $element->css($property_name)

## 'GET', 'POST', or 'DELETE' to the same command examples

### When you can do multiple http methods for the same command, call the command directly for the 'GET', and prepend the http method for the 'POST' or 'DELETE'.

*   Set landscape orientation with 'POST'

        // POST /session/:sessionId/orientation
        $session->postOrientation(array('orientation' => 'LANDSCAPE'));

*   Get landscape orientation with normal 'GET'

        // GET /session/:sessionId/orientation
        $session->orientation();

*   Set size of window that has $window_handle with 'POST'

        // If excluded, $window_handle defaults to 'current'
        // POST /session/:sessionId/window/:windowHandle/size
        $session
          ->window($window_handle)
          ->postSize(array('width' => 10, 'height' => 10));

*   Get current window size with 'GET'

        // GET /session/:sessionId/window/:windowHandle/size
        $session->window()->size();

## Some unavoidable exceptions to direct protocol translation.

*   Opening pages

        // POST /session/:sessionId/url
        $session->open('http://www.facebook.com');

*   Dealing with the session

        // DELETE /session/:sessionId
        $session->close();

        // GET /session/:sessionId
        $session->capabilities();
        
*   To find elements

        // POST /session/:sessionId/element
        $element = $session->element($using, $value);

        // POST /session/:sessionId/elements
        $session->elements($using, $value);

        // POST /session/:sessionId/element/:id/element
        $element->element($using, $value);

        // POST /session/:sessionId/element/:id/elements
        $element->elements($using, $value);

*   To manipulate cookies

        // GET /session/:sessionId/cookie
        $session->getAllCookies();

        // POST /session/:sessionId/cookie
        $session->setCookie($cookie_json);

        // DELETE /session/:sessionId/cookie
        $session->deleteAllCookies()

        // DELETE /session/:sessionId/cookie/:name
        $session->deleteCookie($name)

*   To manipulate windows

        // POST /session/:sessionId/window
        $session->focusWindow($window_handle);

        // DELETE /session/:sessionId/window
        $session->deleteWindow();

### See also [wiki page of examples](https://github.com/facebook/php-webdriver/wiki/Example-command-reference).

##  RELEASE PEAR PACKAGE

The package.xml is really hard to maintain, and till now, no such reliable PEAR tool for this.

By using Onion, we can generate the package.xml for PEAR installer very easily 
through a 5~8 lines config file, then people can install it through Facebook's
PEAR channel or install from command-line directly.

    $ vim package.ini
    $ curl -O https://github.com/c9s/Onion/raw/master/onion.phar
    $ php onion.phar build 
    $ pear install -f package.xml

Or install through Facebook's PEAR channel:

    $ pear install facebook/WebDriver

To use WebDriver in one project as a dependency, can use Onion's bundle feature, for example:

1. define package.ini
2. run onion.phar bundle
    
    $ php onion.phar -d bundle

3. then WebDriver will be installed into the path vendor/pear.

### PEAR CHANNEL

To release this package on PEAR channel, can use Prium (PEAR channel builder)

1. define pirum pirum.xml (5~10 lines xml)
2. run pirum add package
3. run prium build

Success!

Reference:

- https://github.com/c9s/Onion
- http://pirum.sensiolabs.org/
