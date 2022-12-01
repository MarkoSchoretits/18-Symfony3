<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Anniversary;
use App\Form\BirthdaysType;

class BirthdaysController extends AbstractController
{
    #[Route('/birthdays', name: 'birthdays')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $birthdays = $doctrine->getRepository(Anniversary::class)->findAll();

        return $this->render('birthdays/index.html.twig', ['birthdays' => $birthdays,
            'controller_name' => 'BirthdaysController',
        ]);
    }
    #[Route('/birthdays/create', name: 'birthdays_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $anniversary = new Anniversary();
        $form = $this->createForm(BirthdaysType::class, $anniversary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
/*            $now = new \DateTime('now');
            
            $anniversary = $form->getData();
            $anniversary->setCreateDate($now);
 */
            $em = $doctrine->getManager();
            $em->persist($anniversary);
            $em->flush();

            $this->addFlash(
                'notice',
                'Anniversary Added'
            );

            return $this->redirectToRoute('birthdays');
        }
        return $this->render('birthdays/create.html.twig', [
            'form' => $form->createView()]);
    }

    #[Route('/edit/{id}', name: 'birthdays_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $anniversary = $doctrine->getRepository(Anniversary::class)->find($id);
        $form = $this->createForm(BirthdaysType::class, $anniversary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime('now');
            $anniversary = $form->getData();
/*             $anniversary->setCreateDate($now);
 */            $em = $doctrine->getManager();
            $em ->persist($anniversary);
            $em->flush();
            $this->addFlash(
                'notice',
                'Anniversary Edited'
                );
            return $this->redirectToRoute('birthdays');
        }
        return $this->render('birthdays/edit.html.twig', [
            'form' => $form->createView()]);
    }

    #[Route('/details/{id}', name: 'birthdays_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $anniversary = $doctrine->getRepository(Anniversary::class)->find($id);

        return $this->render('birthdays/details.html.twig', 
        ['anniversary' => $anniversary]);
    }

    #[Route('/delete/{id}', name: 'birthdays_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $anniversary = $em->getRepository(Anniversary::class)->find($id);
        $em->remove($anniversary);
        
        $em->flush();
        $this->addFlash(
            'notice',
            'Anniversary Removed'
        );
        
        return $this->redirectToRoute('birthdays');
    }
}
