<?php


namespace App\Service;


use App\Entity\Offer;
use App\Entity\Server;
use App\Entity\Store;
use App\Entity\User;
use App\Service\SearchTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class ProcessModDataService
{
    use SearchTrait;
    private $em;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->em = $entity_manager;
    }

    public function processServerData(array $data)
    {
        /** @var Server $server */
        $server = $this->em->getRepository(Server::class)->findOneBy(['name' => Server::SERVER_NAME]);
        if (!$server)
        {
            return;
        }

        $server->updateFromMod($data);
        $this->em->flush();
    }

    public function processUserData(array $data)
    {
        $keep = [];
        /** @var User[] $existing_users */
        $existing_users = $this->em->getRepository(User::class)->findAll();
        foreach($data as $user_data)
        {
            // if user doesn't exist, create it
            $user = $this->entityArraySearch($existing_users, 'getExternalId', $user_data['id']);
            if (!$user)
            {
                $user = User::createFromModData($user_data);
                $this->em->persist($user);
            }
            else
            {
                $user->updateFromModData($user_data);
            }
            $this->processTradeData($user, $user_data['store_offers']);
            $this->em->flush();
            //$this->em->clear();
            $keep[$user->getGuid()] = $user->getGuid();
        }
        $this->removeData($keep, $existing_users);
        $this->em->flush();
    }

    public function processTradeData(User $user, array $stores_data)
    {
        $store_offers = $this->em->getRepository(Offer::class)->findAllForUser($user);
        $keep = [];
        foreach($stores_data as $store_data)
        {
            foreach ($store_data['formatted_offers'] as $offer_data)
            {
                $offer_data['store_id'] = $store_data['id'];
                $offer_data['store_name'] = $store_data['name'];
                $offer_data['currency_name'] = $store_data['currency_name'];
                $offer_data['user_name'] = $user->getName();

                /** @var Offer $user_offer */
                $user_offer = $this->getExistingOffer($offer_data['name'], $offer_data['buying'], $offer_data['store_id'], $store_offers);
                if (!$user_offer)
                {
                    $user_offer = Offer::createFromModData($offer_data);
                    $user_offer->setUser($user);
                    $this->em->persist($user_offer);
                }
                else
                {
                    $user_offer->updateFromModData($offer_data);
                }
                $keep[$user_offer->getGuid()] = $user_offer->getGuid();
            }
        }
        $this->removeData($keep, $store_offers);
    }

    private function getExistingOffer($name, $buying, $store_name, array $store_offers)
    {
        /** @var Offer $offer */
        foreach ($store_offers as $offer)
        {
            if ($name === $offer->getName() && $buying === $offer->getBuying() && $store_name == $offer->getStoreId())
            {
                return $offer;
            }
        }
        return null;
    }

    private function removeData(array $keep, $existing_data)
    {
        foreach($existing_data as $data)
        {
            if (!in_array($data->getGuid(), $keep))
            {
                $this->em->remove($data);
            }
        }
    }
}
