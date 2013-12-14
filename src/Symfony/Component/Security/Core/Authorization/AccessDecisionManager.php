<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Core\Authorization;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * AccessDecisionManager is the base class for all access decision managers
 * that use decision voters.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 2.5, to be removed in 3.0. Use the AccessDecisionManager for the chosen strategy instead.
 */
class AccessDecisionManager implements AccessDecisionManagerInterface
{
    private $strategy;

    /**
     * Constructor.
     *
     * @param VoterInterface[] $voters                             An array of VoterInterface instances
     * @param string           $strategy                           The vote strategy
     * @param Boolean          $allowIfAllAbstainDecisions         Whether to grant access if all voters abstained or not
     * @param Boolean          $allowIfEqualGrantedDeniedDecisions Whether to grant access if result are equals
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $voters, $strategy = 'affirmative', $allowIfAllAbstainDecisions = false, $allowIfEqualGrantedDeniedDecisions = true)
    {
        $strategyClass = 'Symfony\\Component\\Security\\Core\\Authorization\\'.ucfirst($strategy).'AccessDecisionManager';
        if (!class_exists($strategyClass)) {
            throw new \InvalidArgumentException(sprintf('The strategy "%s" is not supported.', $strategy));
        }

        $this->strategy = new $strategyClass($voters, $allowIfAllAbstainDecisions, $allowIfEqualGrantedDeniedDecisions);
    }

    /**
     * {@inheritdoc}
     */
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        return $this->strategy->decide($token, $attributes, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return $this->strategy->supportsAttribute($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $this->strategy->supportsClass($class);
    }
}
