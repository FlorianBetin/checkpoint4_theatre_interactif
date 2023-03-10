<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public static int $userIndex = 0;

    public const USER_INFOS = [
        [
            'nickname' => 'Fab',
            'email' => 'fab@cp4.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_ADMIN'
        ],
        [
            'nickname' => 'Lola',
            'email' => 'lola@cp4.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_USER'
        ],
    ];


    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USER_INFOS as $userInfo) {
            self::$userIndex++;
            $user = new User();
            $user->setEmail($userInfo['email']);
            $user->setNickname($userInfo['nickname']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userInfo['pass']
            );
            $user->setPassword($hashedPassword);

            $user->setRoles(array($userInfo['roles']));
            $manager->persist($user);
            $this->addReference('user_' . self::$userIndex, $user);
        }
        $manager->flush();
    }
}