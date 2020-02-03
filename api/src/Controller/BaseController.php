<?php

namespace App\Controller;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BaseController.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
abstract class BaseController extends AbstractController
{
    public const SERIALIZE_PUBLIC = ['public'];
    public const SERIALIZE_PORTAL = ['portal'];
    public const SERIALIZE_PROFILE = ['profile'];

    /**
     * The value of the groups key can be a single string, or an array of strings.
     *
     * @param SerializerInterface $serializer
     * @param                     $data
     * @param                     $groups
     *
     * @return Response
     */
    public function jsonResponse(SerializerInterface $serializer, $data, array $groups = null)
    {
        $context = [];
        if (is_array($groups))
        {
            $context = ['groups' => $groups];
        }

        return new JsonResponse(
            $serializer->serialize(
                $data,
                'json',
                $context
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
