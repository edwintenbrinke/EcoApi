<?php


namespace App\Service;


use App\Entity\Buy;
use App\Entity\Craft;
use App\Entity\Harvest;
use App\Entity\Pickup;
use App\Entity\Place;
use App\Entity\Play;
use App\Entity\Sell;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityService
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class EntityService
{
    private $em;

    public $stack_class = null;

    public $stack_data = [];

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

    public function createEntity(string $entity_class, array $data)
    {
        if ($entity_class === Buy::class || $entity_class === Sell::class)
        {
            $this->handleStackableData($entity_class, $data);
        }
        else
        {
            // if there is still stacked data persist it because its a new entity
            $this->finishStackedData();
            $this->createFromEcoData($entity_class, $data);
        }
    }

    public function finishStackedData()
    {
        if (count($this->stack_data) > 0 && $this->stack_class !== null)
        {
            $this->createStackedEntity();
        }
    }

    private function handleStackableData(string $entity_class, array $data)
    {
        // if first time
        if (count($this->stack_data) === 0 && $this->stack_class === null)
        {
            $this->stack_class = $entity_class;
            $this->stack_data[] = $data;
            return;
        }
        else
        {
            // if its the same sale continue stacking
            if (
                $this->stack_class === $entity_class
                && $data['ItemTypeName'] === $this->stack_data[0]['ItemTypeName']
                && $data['Username'] === $this->stack_data[0]['Username']
                && $data['AuthId'] === $this->stack_data[0]['AuthId']
                && $data['WorldObjectId'] === $this->stack_data[0]['WorldObjectId']
            )
            {
                $this->stack_data[] = $data;
                return;
            }
            else
            {
                // its a different sale
                $this->createStackedEntity();
                $this->stack_class = $entity_class;
                $this->stack_data[] = $data;
                return;
            }
        }
    }

    // finish a stacked entry
    private function createStackedEntity()
    {
        $this->stack_data[0]['Amount'] = count($this->stack_data);
        $this->createFromEcoData($this->stack_class, $this->stack_data[0]);
        // reset after persisting
        $this->stack_class = null;
        $this->stack_data = [];
    }

    // create & persist the data
    private function createFromEcoData(string $entity_class, $data)
    {
        /** @var Buy $entity_class */
        $entity = $entity_class::createFromEcoData($data);
        $this->em->persist($entity);
    }
}
