<?php
namespace OCFram;

class Config extends ApplicationComponent
{
    protected $vars = [];

    public function get($var)
    {
        if (empty($this->vars))
        {
            $xml = new \DOMDocument('1.0', 'utf-8');
            $xml->load(__DIR__."/../../App/".$this->app->name()."/Config/app.xml");
            foreach ($xml->getElementsByTagName("define") as $define)
            {
                $this->vars[$define->getAttribute("var")] = $define->getAttribute("value");
            }
        }

        return isset($this->vars[$var]) ? $this->vars[$var] : null;
    }
}