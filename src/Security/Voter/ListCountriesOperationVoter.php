<?php

namespace App\Security\Voter;

use App\Operation\ApiOperationSubject;
use App\Operation\ListCountriesOperation;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ListCountriesOperationVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {
        if(!$subject instanceof ApiOperationSubject){
            return false;
        }

        return $subject->getGroup() === 'COUNTRY';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if(!in_array('ROLE_SUPERUSER', $user->getRoles())){
            return false;
        }

        return true;
    }
}
