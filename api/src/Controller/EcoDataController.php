<?php


namespace App\Controller;


use App\Service\ProcessModDataService;
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
     * @Route("/api/eco/mod/data", name="api_eco_mod_data")
     * @param Request               $request
     * @param                       $eco_mod_data_folder
     * @param                       $eco_access_token
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getModData(Request $request, $eco_mod_data_folder, $eco_access_token)
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

        $file_name = sprintf('mod-data-%s.json', (new \DateTime())->format('Y-m-d\TH:i:s'));
        $file_path = sprintf('%s%s', $eco_mod_data_folder, $file_name);
        $temp_file = fopen(
            $file_path,
            'w'
        );

        fwrite(
            $temp_file,
            $request->getContent()
        );
        fclose($temp_file);

        return new JsonResponse([
            'message' => 'Data receiverd'
        ]);
    }

    /**
     * @Route("/api/eco/data", name="api_eco_data")
     * @param Request         $request
     * @param LoggerInterface $eco_api_logger
     * @param                 $eco_data_folder
     * @param                 $eco_access_token
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, LoggerInterface $eco_api_logger, $eco_data_folder, $eco_access_token)
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

        $eco_api_logger->info('Request', [
            'headers' => $request->headers
        ]);

        $content = json_decode($request->getContent(), true);
        if (!is_array($content)) $content = [];

        foreach ($content as $key => $collection)
        {
            $content[$key] = [];
            foreach ($collection as $entry)
            {
                $content[$key][] = array_filter(
                    $entry,
                    function($value) {
                        return !is_null($value) && $value !== '' && $value !== '00000000-0000-0000-0000-000000000000' && $value !== 0.0;
                    }
                );
            }
        }

        $file_name = sprintf('eco-data-%s.json', (new \DateTime())->format('Y-m-d\TH:i:s'));
        $file_path = sprintf('%s%s', $eco_data_folder, $file_name);
        $temp_file = fopen(
            $file_path,
            'w'
        );

        $eco_api_logger->info('Writing to file.', [
            'file_name' => $file_name,
            'memory' => [
                'allocated' => sprintf('%d KB', (memory_get_peak_usage() / 1024)),
                'real_usage' => sprintf('%d KB', (memory_get_peak_usage(true) / 1024)),
            ],
        ]);

        fwrite(
            $temp_file,
            json_encode($content)
        );
        fclose($temp_file);

        $eco_api_logger->info('File written.', [
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
