<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use KejawenLab\Semart\Skeleton\Service\IndonesiaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;



/**
 * @author Muhammad Rifqi <muhammadrifqi.tb@gmail.com>
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home_dashboard")
     */
    public function index(IndonesiaService $indonesiaService, SerializerInterface $serializer)
    {
        return $this->render('dashboard/index.html.twig', [
            'title' => 'Dashboard Kementerian',
            'provinces' => $serializer->serialize($indonesiaService->getProvinces(), 'json', ['groups' => ['read']])
        ]);
    }

    /**
     * @Route("/satker" , methods={"GET"} , name="dashboard_satker" , options={"expose"= true})
     */
    public function satuanKerja(Request $request)
    {
      return $this->render('dashboard/satker/index.html.twig', [
          'title' => $request->get('name'),
          'satker' => $request->get('name')
      ]);
    }

    /**
     * @Route("/kabag" , methods={"GET"} , name="dashboard_kabag" , options={"expose"= true})
     */
    public function kabag(Request $request)
    {
      return $this->render('dashboard/kabag/index.html.twig', [
          'title' => $request->get('name'),
          'satker' => $request->get('name')
      ]);
    }

    /**
     * @Route("/kegiatan/{activity}" , methods={"GET"} , name="activity_detail" , options={"expose"= true})
     */
    public function activityDetail($activity)
    {
      return $this->render('dashboard/kegiatan.html.twig', [
          'title' => $activity,
          'activity' => $activity
      ]);
    }
}
