<?php

namespace App\DataFixtures;

use App\Entity\Server;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $server = new Server();
        $server->setName(Server::SERVER_NAME);
        $manager->persist($server);
        $manager->flush();
    }
}
