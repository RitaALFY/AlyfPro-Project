<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $imageNames = [  'mga.png','m2i.png','isitech.png','president.png', 'delcoupe.png', 'oip.png','orsys.png','fit.png','edu.png','ort.png' ];

        return $this->render('front/pages/home.html.twig', [
            'controller_name' => 'HomeController',
            'imageNames' => $imageNames,
        ]);
    }




    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('front/pages/about.html.twig');
    }

    #[Route('/services', name: 'app_services')]
    public function service(): Response
    {
        return $this->render('front/pages/service.html.twig');
    }
//    #[Route('/references', name: 'app_references')]
//    public function reference(): Response
//    {
//        $imageNames = [  'mga.png','m2i.png','isitech.png','president.png', 'delcoupe.png', 'oip.png','orsys.png','fit.png','edu.png','ortsm.png' ];
//        return $this->render('front/pages/references.html.twig', [
//            'imageNames' => $imageNames,
//        ]);
//    }


}
