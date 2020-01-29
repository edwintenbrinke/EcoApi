<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EcoDataController
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class EcoDataController extends AbstractController
{
    /**
     * @Route("/test")
     * @return JsonResponse
     */
    public function test()
    {
        return new JsonResponse(['message' => 'hi']);
    }

    /**
     * @Route("/api/eco/data", name="api_eco_data")
     * @param Request         $request
     * @param LoggerInterface $eco_logger
     * @param                 $eco_data_folder
     * @param                 $eco_access_token
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, LoggerInterface $eco_logger, $eco_data_folder, $eco_access_token)
    {
        // authorize
        $token = $request->headers->get('Authorization');
        if (!$token)
        {
            throw new UnauthorizedHttpException('Add Authorization token', 'No Authorization header found');
        }

        if ($token !== $eco_access_token)
        {
            throw new UnauthorizedHttpException('Invalid token', 'You\'re not authorized to access this url');
        }

        $eco_logger->info('Request', [
            'headers' => $request->headers,
            'body' => $request->getContent(),
        ]);

        $file_name = sprintf('eco-data-%s.json', (new \DateTime())->format('Y-m-d\TH:i:s'));
        $file_path = sprintf('%s%s', $eco_data_folder, $file_name);
        $temp_file = fopen(
            $file_path,
            'w'
        );

        $eco_logger->info('Writing to file.', [
            'file_name' => $file_name,
            'memory' => [
                'allocated' => sprintf('%d KB', (memory_get_peak_usage() / 1024)),
                'real_usage' => sprintf('%d KB', (memory_get_peak_usage(true) / 1024)),
            ],
        ]);

        fwrite($temp_file, $request->getContent());
        fclose($temp_file);

        $eco_logger->info('File written.', [
            'file_name' => $file_name,
            'memory' => [
                'allocated' => sprintf('%d KB', (memory_get_peak_usage() / 1024)),
                'real_usage' => sprintf('%d KB', (memory_get_peak_usage(true) / 1024)),
            ],
        ]);

        return new JsonResponse([
            'message' => 'Successfully received & stored data'
        ]);
    }
}
