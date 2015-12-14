<?php
namespace Helpers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Storage\Session;

class SessionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $c)
    {
        $c['session'] = function () {
            return Session::getInstance();
        };
    }
}
