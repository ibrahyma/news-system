<?php
namespace OCFram;

use App\Frontend\Modules\News\NewsController;

abstract class Application
{
    protected $config;
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;
    
    public function __construct()
    {
        $this->config = new Config($this);
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->name = '';
        $this->user = new User($this);
    }

    public function config()
    {
        return $this->config;
    }

    public function getController()
    {
        $router = new Router;
        
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$this->name().'/Config/routes.xml');

        $routes = $xml->getElementsByTagName('route');
        foreach ($routes as $route)
        {
            $vars = [];
            
            if ($route->hasAttribute('vars'))
            {
                $vars = explode(',', $route->getAttribute('vars'));
            }

            $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
        }
        
        try
        {
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                $this->httpResponse->redirect404();
            }
        }
        // On ajoute les variables de l'URL au tableau $_GET.
        $_GET = array_merge($_GET, $matchedRoute->vars());
        // On instancie le contrôleur.
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }
        
    public function httpRequest()
    {
        return $this->httpRequest;
    }
    
    public function httpResponse()
    {
        return $this->httpResponse;
    }
    
    public function name()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->user;
    }

    abstract public function run();
}