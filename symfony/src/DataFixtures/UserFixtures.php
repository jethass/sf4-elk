<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
         $user1 = new User();
         $user1->setEmail('admin-test@hotmail.fr');
         $user1->setPassword($this->passwordEncoder->encodePassword($user1,'admin'));
         $user1->setRoles(array('ROLE_ADMIN'));
         $manager->persist($user1);
         $manager->flush();

        $user2 = new User();
        $user2->setEmail('user-test@hotmail.fr');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2,'user'));
        $manager->persist($user2);
        $manager->flush();
    }
}
