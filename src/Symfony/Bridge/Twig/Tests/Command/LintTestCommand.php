<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Tests\Command;

use Symfony\Bridge\Twig\Command\LintCommand as BaseLintCommand;

class LintTestCommand extends BaseLintCommand
{
    public $twig;

    protected function getTwigEnvironment()
    {
        return $this->twig;
    }
}
