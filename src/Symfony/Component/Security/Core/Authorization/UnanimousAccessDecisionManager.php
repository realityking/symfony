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
 * Grants access if only grant (or abstain) votes were received.
 *
 * If all voters abstained from voting, the decision will be based on the
 * allowIfAllAbstainDecisions property value (defaults to false).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UnanimousAccessDecisionManager extends AbstractAccessDecisionManager
{
    private $allowIfAllAbstainDecisions;

    /**
     * Constructor.
     *
     * @param VoterInterface[] $voters                     An array of VoterInterface instances
     * @param Boolean          $allowIfAllAbstainDecisions Whether to grant access if all voters abstained or not
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $voters, $allowIfAllAbstainDecisions = false)
    {
        parent::__construct($voters);

        $this->allowIfAllAbstainDecisions = (Boolean) $allowIfAllAbstainDecisions;
    }

    /**
     * {@inheritdoc}
     */
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        $grant = 0;
        foreach ($attributes as $attribute) {
            foreach ($this->voters as $voter) {
                $result = $voter->vote($token, $object, array($attribute));

                switch ($result) {
                    case VoterInterface::ACCESS_GRANTED:
                        ++$grant;

                        break;

                    case VoterInterface::ACCESS_DENIED:
                        return false;

                    default:
                        break;
                }
            }
        }

        // no deny votes
        if ($grant > 0) {
            return true;
        }

        return $this->allowIfAllAbstainDecisions;
    }
}
