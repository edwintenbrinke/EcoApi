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
            // make this better
            $user = $this->entityArraySearch($existing_users, 'getSlgId', $user_data['slg_id']);
            if (!$user)
            {
                $user = $this->entityArraySearch($existing_users, 'getSteamId', $user_data['steam_id']);
            }
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
            $keep[$user->getId()] = $user;
        }
        $this->removeData($keep, $existing_users);
        $this->em->flush();
    }

    public function processTradeData(User $user, array $stores_data)
    {
        $keep = [];
        $user_stores = $user->getStores();
        foreach($stores_data as $store_data)
        {
            /** @var Store $user_store */
            $user_store = $this->entityArraySearch($user_stores, 'getExternalId', $store_data['id']);
            if (!$user_store)
            {
                $user_store = Store::createFromModData($store_data);
                $user_store->setUser($user);
                $this->em->persist($user_store);
            }
            else
            {
                $user_store->updateFromModData($store_data);
            }
            $this->processOfferData($user_store, $store_data['formatted_offers']);
            $keep[$user_store->getId()] = $user_store;
        }
        $this->removeData($keep, $user_stores);
    }

    public function processOfferData(Store $user_store, array $offers_data)
    {
        $keep = [];
        $store_offers = $user_store->getOffers();
        foreach ($offers_data as $offer_data)
        {
            $user_offer = $this->entityArraySearch($store_offers, 'getName', $offer_data['name']);
            if (!$user_offer)
            {
                $user_offer = Offer::createFromModData($offer_data);
                $user_offer->setStore($user_store);
                $this->em->persist($user_offer);
            }
            else
            {
                $user_offer->updateFromModData($offer_data);
            }
            $keep[$user_offer->getId()] = $user_offer;
        }
        $this->removeData($keep, $store_offers);
    }

    private function removeData(array $keep, $existing_data)
    {
        foreach($existing_data as $data)
        {
            if (!array_key_exists($data->getId(), $keep))
            {
                $this->em->remove($data);
            }
        }
    }
}
