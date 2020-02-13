<?php


namespace App\Controller;


use App\Entity\Item;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ItemController
 * @Route("/api")
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class ItemController extends BaseController
{
    /**
     * @Route("/item/{id}/icon")
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param Item                   $item
     *
     * @return JsonResponse
     */
    public function getImage(Request $request, EntityManagerInterface $em, Item $item)
    {
        $body = json_decode($request->getContent());

        $cache = new ApcuCache();
        $cache_icon = $cache->fetch('item.' . $body->item_name);
        if ($cache_icon)
        {
            return new JsonResponse(['icon_url' => $cache_icon]);
        }

        $name = $body->item_name;
        $response = file_get_contents("https://eco.gamepedia.com/$name");
        $icon_name = str_replace("_","", $name);

        $regex = ";https://gamepedia\.cursecdn\.com/eco_gamepedia(/[a-z0-9]{1,2}/[a-z0-9]{1,2}/)".$icon_name."_Icon\.png\?;";
        preg_match($regex, $response, $matches);

        $icon_url = "https://gamepedia.cursecdn.com/eco_gamepedia/thumb" . $matches[1] . $icon_name."_Icon.png/50px-".$icon_name."_Icon.png";

        $cache->save('item.'.$name, $icon_url);

        $item->setIcon($icon_url);
        $em->flush();

        return new JsonResponse(['icon_url' => $icon_url]);
    }
}
