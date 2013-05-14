<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ActionName extends AbstractHelper
{
    protected $routerMatch;

    public function __construct($routerMatch)
    {
        $this->routerMatch = $routerMatch;
    }
    
    public function __invoke()
    {
        $controller = $this->routerMatch->getParam('action','index');
        return $controller;
    }
}