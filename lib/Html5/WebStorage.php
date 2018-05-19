<?php

namespace Facebook\WebDriver\Html5;

/**
 * Represents browser storage for the current site.
 */
interface WebStorage
{
    /**
     * Get the local storage for the site currently opened in the browser.
     *
     * @return LocalStorage
     */
    public function getLocalStorage();

    /**
     * Get the session storage for the site currently opened in the browser.
     *
     * @return SessionStorage
     */
    public function getSessionStorage();
}
