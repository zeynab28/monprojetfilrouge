<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}
    public function load(ObjectManager $manager)
    {
      
        $utilisateur = new User();
        $utilisateur->setUsername("zeynab");
        $password=$this->encoder->encodePassword($utilisateur,"123");
        $utilisateur->setPassword($password);
        $utilisateur->setRoles(['ROLE_SUPER_ADMIN']);
        $utilisateur->setPrenom("SEYNABOU");
        $utilisateur->setNom("NDIAYE");
        $utilisateur->setTel(778106222);
        $utilisateur->setAdresse("Rufisque");
        $utilisateur->setEmail("ndiaye@gmail.com");
        $utilisateur->setUpdatedAt(new \DateTime());
       $utilisateur->setImageName("hftgtgg.jpg");
        $manager->persist($utilisateur);
        $manager->flush();
    }
}
