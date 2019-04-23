<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;
    public  function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder= $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
    	$this->createMany(10, 'main_users', function($i)
    	{
    		$user=new User();
    		$user->setEmail(sprintf('spacebar%d@example.com',$i));
    		$user->setFirstName($this->faker->firstName);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'engage'));
            if($this->faker->bollean)
            {
                $user->setTwitterUsername($this->faker->userName);
            }

    		return $user;
    	}
    	);
        $this->createMany(10, 'admin_users', function($i)
        {
            $user=new User();
            $user->setEmail(sprintf('admin%d@example.com',$i));
            $user->setFirstName($this->faker->firstName);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'engage'));

            return $user;
        }
        );
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
