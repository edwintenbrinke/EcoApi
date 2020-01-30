<?php


namespace App\Service;


use App\Entity\Buy;
use App\Entity\Craft;
use App\Entity\Harvest;
use App\Entity\Pickup;
use App\Entity\Place;
use App\Entity\Play;
use App\Entity\Sell;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class EntityService
{
    private $em;
    private $users;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->em = $entity_manager;
    }

    public static function chooseEntityClass(string $collection)
    {
        /** @var Pickup $entity_class */
        switch ($collection)
        {
            case 'PickupAction':
                $entity_class = Pickup::class;
                break;
            case 'PlayAction':
                $entity_class = Play::class;
                break;
            case 'CraftAction':
                $entity_class = Craft::class;
                break;
            case 'HarvestAction':
                $entity_class = Harvest::class;
                break;
            case 'PlaceAction':
                $entity_class = Place::class;
                break;
            case 'BuyAction':
                $entity_class = Buy::class;
                break;
            case 'SellAction':
                $entity_class = Sell::class;
                break;
            default:
            {
                return null;
            }
        }

        return $entity_class;
    }
}
