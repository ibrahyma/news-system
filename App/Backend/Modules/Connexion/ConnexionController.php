<?php
namespace App\Backend\Modules\Connexion;

use OCFram\BackController;
use OCFram\HTTPRequest;

class ConnexionController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page()->addVar("title", "Connexion");

        if ($request->postExists("connect"))
        {
            $loginTrue = $request->postData("login") == $this->app()->config()->get("login");
            $passTrue = $request->postData("pass") == $this->app()->config()->get("pass");
            
            if ($loginTrue AND $passTrue)
            {
                $this->app()->user()->setAuthenticated();
                $this->app()->httpResponse()->redirect(".");
            }
            else
            {
                $this->app()->user()->setFlash("Login et/ou mot de passe incorrect.");
            }
        }
    }

    public function executeDisconnect(HTTPRequest $request)
    {
        $this->app()->user()->setAuthenticated(false);
        $this->app()->httpResponse()->redirect("/");
    }
}