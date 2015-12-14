<?php
/* file name  : lib/classes/Helpers/DBServiceProvider.php
 * created    : Tue 04 Aug 2015 12:41:23 PM EEST
 *
 * modifications: This class registered DB class(Medoo) to pimple
 *
 */

namespace Helpers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Medoo\medoo;

class DBServiceProvider implements ServiceProviderInterface
{
    public function register(Container $c)
    {
        $c['db'] = function ($c) {
            return new medoo($c['db_connect']);
        };
    }
}
