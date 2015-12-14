<?php
/* file name  : lib/classes/Helpers/DBServiceProvider.php
 * created    : Tue 24 Aug 2015 12:41:23 PM EEST
 *
 * modifications: This class registered Language class to pimple
 *
 */

namespace Helpers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Tools\Languages;

class LanguageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $c)
    {
        $c['language'] = function ($c) {
            return Languages::getInstance(
                array_merge(
                    $c['language_config'],
                    ['database' => $c['db']]
                )
            );
        };
    }
}
