<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogueController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {}

    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(): Response
    {
        return $this->render('front/pages/catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/catalogue/show/{id}', name: 'app_catalogue_show')]
    public function listShow(int $id): Response
    {
        $catalogue = $this->categoryRepository->find($id);

        if (!$catalogue) {
            throw new NotFoundHttpException('Sorry, catalogue not found');
        }

        return $this->render('front/pages/catalogue/listShow.html.twig', [
            'catalogue' => $catalogue,
        ]);
    }
}
