<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    private MailerInterface $mailer;
    private TranslatorInterface $translator;

    public function __construct(MailerInterface $mailer, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Traitez le formulaire ici et envoyez l'e-mail
                $message = $form->get('VotreMessage')->getData();
                $email = (new Email())
                    ->to('rita.atmajaalfy@gmail.com')
                    ->subject('Nouveau message de contact')
                    ->text($message);

                $this->mailer->send($email);

                // alert confirmer et redirigez ensuite l'utilisateur vers une page
                $this->addFlash(
                    'success',
                    $this->translator->trans('pages.contact.success_submit')
                );
                return $this->redirectToRoute('app_contact');
//                return $this->json(['message' => 'Votre message a été bien envoyé'], Response::HTTP_OK);
            }
            else {
                // Message flash en cas d'échec
                $this->addFlash(
                    'danger',
                    $this->translator->trans('pages.contact.failure_submit')
                );
            }

        }
        return $this->render('front/pages/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
