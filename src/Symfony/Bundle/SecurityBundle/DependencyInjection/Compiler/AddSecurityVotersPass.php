<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SecurityBundle\DependencyInjection\Compiler;

use Symfony\Component\Security\Core\DependencyInjection\AddSecurityVotersPass as BaseAddSecurityVotersPass;

/**
 * Adds all configured security voters to the access decision manager
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @deprecated Deprecated in 2.5, to be removed in 3.0. Use Symfony\Component\Security\Core\DependencyInjection\AddSecurityVotersPass instead.
 */
class AddSecurityVotersPass extends BaseAddSecurityVotersPass
{
}
