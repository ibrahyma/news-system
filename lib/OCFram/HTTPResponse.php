<?php
namespace OCFram;

class HTTPResponse extends ApplicationComponent
{
    protected $page;

    public function addHeader($header)
    {
        header($header);
    }

    public function redirect($location)
    {
        header("location:$location"); exit;
    }

    public function redirect403()
    {
        $this->page = new Page($this->app);
        $this->page->setContentFile(__DIR__."/../../Errors/403.html");
        $this->addHeader("HTTP/1.0 403 Forbidden");
        $this->send();
    }

    public function redirect404()
    {
        $this->page = new Page($this->app);
        $this->page->setContentFile(__DIR__."/../../Errors/404.html");
        $this->addHeader("HTTP/1.0 404 Not Found");
        $this->send();
    }

    public function send()
    {
        exit($this->page->getGeneratedPage());
    }

    public function setCookie($name, $value = "", int $expire = 0, $path = null, $domain = null, bool $secure = false, bool $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    public function setPage(Page $page)
    {
        $this->page = $page;
    }
}