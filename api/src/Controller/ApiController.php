<?php


namespace App\Controller;


use App\Entity\Buy;
use App\Entity\Sell;
use App\Entity\Server;
use App\Repository\BuyRepository;
use App\Repository\CraftRepository;
use App\Repository\HarvestRepository;
use App\Repository\PickupRepository;
use App\Repository\PlaceRepository;
use App\Repository\PlayRepository;
use App\Repository\SellRepository;
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
     * @Route("/server", name="server_info", methods={"GET"})
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     *
     * @return JsonResponse
     */
    public function getServerData(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        return new JsonResponse(
            $serializer->serialize(
                $em->getRepository(Server::class)->findOneBy(['name' => Server::SERVER_NAME]),
                'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
    /**
     * @Route("/sell", name="api_sell", methods={"GET"})
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     *
     * @return Response
     */
    public function getSellData(Request $request, SellRepository $sell_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
                [
                    'items' => $sell_repository->findPaginatedForPortal($options),
                    'total_items_count' => (int) $sell_repository->countPaginatedAll($options),
                ],
                'json'
        );
    }

    /**
     * @Route("/buy", name="api_buy", methods={"GET"})
     * @param Request             $request
     * @param BuyRepository       $buy_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getBuyData(Request $request, BuyRepository $buy_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $buy_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $buy_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }

    /**
     * @Route("/craft", name="api_craft", methods={"GET"})
     * @param Request             $request
     * @param CraftRepository     $craft_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getCraftData(Request $request, CraftRepository $craft_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $craft_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $craft_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }

    /**
     * @Route("/harvest", name="api_harvest", methods={"GET"})
     * @param Request             $request
     * @param HarvestRepository   $harvest_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getHarvestData(Request $request, HarvestRepository $harvest_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $harvest_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $harvest_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }

    /**
     * @Route("/pickup", name="api_pickup", methods={"GET"})
     * @param Request             $request
     * @param PickupRepository    $pickup_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getPickupData(Request $request, PickupRepository $pickup_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $pickup_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $pickup_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }

    /**
     * @Route("/place", name="api_place", methods={"GET"})
     * @param Request             $request
     * @param PlaceRepository     $place_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getPlaceData(Request $request, PlaceRepository $place_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $place_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $place_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }

    /**
     * @Route("/play", name="api_play", methods={"GET"})
     * @param Request             $request
     * @param PlayRepository      $play_repository
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getPlayData(Request $request, PlayRepository $play_repository, SerializerInterface $serializer)
    {
        $options = json_decode($request->query->get('options'));
        return $this->jsonResponse(
            $serializer,
            [
                'items' => $play_repository->findPaginatedForPortal($options),
                'total_items_count' => (int) $play_repository->countPaginatedAll($options),
            ],
            'json'
        );
    }
}
