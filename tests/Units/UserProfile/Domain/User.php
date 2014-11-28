<?php

namespace Afsy\Tests\Units\UserProfile\Domain;

use mageekguy\atoum;

use Afsy\UserProfile\Domain\User as SUT;
use Afsy\Common\Domain\UserIdentity;
use Afsy\Common\Domain\Password\PlainPassword;

class User extends atoum\test
{
    /**
     * @dataProvider dataGoodPasswords
     */
    public function test_user_should_authenticate_successfull_with_same_password($password)
    {
        $this
            ->given(
                $mockEncoder = $this->shouldMockPasswordEncoder(),
                $sut = new SUT,
                $sut->register(new UserIdentity('Jean', 'Marc', 'jm@ecureil.fr'), new PlainPassword($password, $mockEncoder))
            )
            ->when(
                $authenticated = $sut->authenticate(new PlainPassword($password, $mockEncoder))
            )
            ->then
                ->boolean($authenticated)
                    ->isTrue()
        ;
    }

    public function dataGoodPasswords()
    {
        return array(
            array('ecureuil'),
            array('12343lkjdslk'),
            array('FFHUHF!à')
        );
    }

    /**
     * @dataProvider dataWrongPasswords
     */
    public function test_user_should_fail_authentication_with_wrong_password($passwordDuringRegistration, $passwordDuringAuthentication)
    {
        $this
            ->given(
                $mockEncoder = $this->shouldMockPasswordEncoder(),
                $sut = new SUT,
                $sut->register(new UserIdentity('Jean', 'Marc', 'jm@ecureil.fr'), new PlainPassword($passwordDuringRegistration, $mockEncoder))
            )
            ->when(
                $authenticated = $sut->authenticate(new PlainPassword($passwordDuringAuthentication, $mockEncoder))
            )
            ->then
                ->boolean($authenticated)
                    ->isFalse()
        ;
    }

    public function dataWrongPasswords()
    {
        return array(
            array('ecureuil', 'flop'),
            array('12343lkjdslk', 'jzfùkdsjf'),
            array('FFHUHF!à', '121323jkLj')
        );
    }

    private function shouldMockPasswordEncoder()
    {
        $mockEncoder = new \mock\Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
        $mockEncoder->getMockController()->encodePassword = function ($raw, $salt) {
            return $raw.$salt;
        };

        return $mockEncoder;
    }
}
