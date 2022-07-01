<?php

namespace Borzoni\GpgManager\FactoryMethods\Gnupg;

use gnupg;

trait GnupgFactoryMethod
{
    /**
     * @return \gnupg
     */
    protected static function staticCreateGnupg(): gnupg
    {
        $gnupg = new gnupg();
        $gnupg->seterrormode(GNUPG_ERROR_WARNING);
        return $gnupg;
    }

    /**
     * @return \gnupg
     */
    protected function createGnupg(): gnupg
    {
        return self::staticCreateGnupg();
    }
}
