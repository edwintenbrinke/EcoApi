<?php


namespace App\Controller;


use App\Entity\Buy;
use App\Entity\Sell;
use App\Entity\Server;
use App\Repository\BuyRepository;
use App\Repository\CraftRepository;
use App\Repository\HarvestRepository;
use App\Repository\OfferRepository;
use App\Repository\PickupRepository;
use App\Repository\PlaceRepository;
use App\Repository\PlayRepository;
use App\Repository\SellRepository;
use App\Repository\ServerRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ApiController
 * @Route("/api")
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class ApiController extends BaseController
{
    /**
     * @Route("/users", name="users_info", methods={"GET"})
     * @param UserRepository      $user_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getUserData(Request $request, UserRepository $user_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $user_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $user_repository->countPaginatedAll($options),
            ],
            self::SERIALIZE_PUBLIC
        );
    }

    /**
     * @Route("/trades", name="trades_info", methods={"GET"})
     * @param StoreRepository     $store_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getTrades(StoreRepository $store_repository, SerializerInterface $serializer)
    {
        return $this->jsonResponse(
            $serializer,
            $store_repository->findAll(),
            self::SERIALIZE_PUBLIC
        );
    }

    /**
     * @Route("/offers", name="offers_info", methods={"GET"})
     * @param OfferRepository     $offer_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getOffers(Request $request, OfferRepository $offer_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $offer_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $offer_repository->countPaginatedAll($options),
            ],
            ['offers']
        );
    }

    /**
     * @Route("/server", name="server_info", methods={"GET"})
     * @param ServerRepository    $server_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getServerData(ServerRepository $server_repository, UserRepository $user_repository,SerializerInterface $serializer)
    {
        return $this->jsonResponse(
            $serializer,
            [
                'server' => $server_repository->findOneBy(['name' => Server::SERVER_NAME]),
                'users' => $user_repository->findBy(['online' => true]),
            ],
            self::SERIALIZE_PUBLIC
        );
    }
}
