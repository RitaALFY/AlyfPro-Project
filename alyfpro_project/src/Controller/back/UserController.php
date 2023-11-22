<?php

namespace App\Controller\back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
//use App\Service\Entity\UserService;
use App\Service\FileUploader;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formateurs')]
class UserController extends AbstractController
{
    public function __construct(
        private FileUploader $fileUploader,
        private UserService $userService,
        private UserRepository $userRepository,

    ) { }

    #[Route('/', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator,
                          Request        $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findBy([], ['lastName' => 'Asc']),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('back/admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile !== null) {
                $oldFile = $user->getImage();
                if ($oldFile !== null) {
                    $this->fileUploader->cleanUnusedFiles($oldFile);
                }
                $user->setImage(
                    $this->fileUploader->uploadFile(
                        $uploadedFile,
                    )
                );
            }
            $this->userRepository->save(
                $this->userService->encodeUserPassword($user),
                true
            );
//            $entityManager->persist($user);
//            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', methods: ['GET'])]
    public function show(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        return $this->render('back/admin/user/show.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile !== null) {
                $oldFile = $user->getImage();
                if ($oldFile !== null) {
                    $this->fileUploader->cleanUnusedFiles($oldFile);
                }
                $user->setImage(
                    $this->fileUploader->uploadFile(
                        $uploadedFile,
                    )
                );
            }
            // Récupérez le nouveau mot de passe depuis le formulaire
            $newPassword = $form->get('password')->getData();

            // Vérifiez si un nouveau mot de passe a été fourni
            if ($newPassword) {
                // Utilisez la nouvelle méthode de UserService pour hacher et mettre à jour le mot de passe
                $this->userService->encodeAndSetUserPassword($user, $newPassword);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
