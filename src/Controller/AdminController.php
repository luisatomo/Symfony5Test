<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)
            ->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
        ]);
    }

    /**
     * @Route("/admin/add", name="admin_add")
     */
    public function add(Request $request): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash('success', 'Event Saved Correctly');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin_edit")
     */
    public function edit($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)
            ->findOneBy(['id' => $id]);

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash('success', 'Event Updated Correctly');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_edit")
     */
    public function delete($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)
            ->findOneBy(['id' => $id]);

        $entityManager->remove($event);
        $entityManager->flush();
        $this->addFlash('success', 'Event Removed Correctly');

        return $this->redirectToRoute('admin');
    }
}
