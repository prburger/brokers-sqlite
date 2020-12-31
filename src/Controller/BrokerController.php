<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Form\BrokerType;
use App\Repository\BrokerRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/broker")
 */
class BrokerController extends AbstractController
{
    /**
     * @Route("/", name="broker_index", methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="broker_index_paginated")
    */
    public function index(Request $_request, int $page = 1, string $_format="html", BrokerRepository $repository): Response
    {
        $brokers = $repository->findLatest($page);
        $pageData = $repository->findLatest($page);

        return $this->render('broker/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
            'brokers'=>$brokers
        ]);
    }

    /**
     * @Route("/new", name="broker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $broker = new Broker();
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/new.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="broker_show", methods={"GET"})
     */
    public function show(Broker $broker): Response
    {
        return $this->render('broker/show.html.twig', [
            'broker' => $broker,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="broker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Broker $broker): Response
    {
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/edit.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="broker_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Broker $broker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$broker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($broker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('broker_index');
    }
}
