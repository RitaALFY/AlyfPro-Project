<?php

namespace App\Controller\back;

use App\Repository\ModuleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        ModuleRepository $moduleRepository,

    ): Response
    { $totalModuleMonths = $moduleRepository->findTotalModuleMonths();
        if (empty($totalModuleMonths)) {
            $totalModuleMonths = [['total' => 0, 'month' => 0]];
        }
        return $this->render('back/admin/dashboard.html.twig', [

            'users' => $userRepository->findBy([], ['lastName' => 'Asc'], 6),
            'totalUsers' => $userRepository->findTotalUsers(),
            'totalModuleMonths' => $moduleRepository->findTotalModuleMonths(),
        ]);
    }
}
