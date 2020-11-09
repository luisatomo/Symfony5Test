<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
