<?php

namespace App\Controller;

use App\Entity\Broker;
use\App\Entity\Contact;
use App\Form\BrokerType;
use\App\Form\ContactFormType;
use App\Repository\BrokerRepository;
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
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="broker_index")
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, methods="GET", name="broker_rss")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="broker_index_paginated")
     * @Cache(smaxage="10")    
    */
    
    public function index(Request $_request, int $page = 1, string $_format="html", BrokerRepository $repository): Response
    {        
        $pageData = $repository->findLatest($page);

        return $this->render('broker/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
        ]);
    }

    /**
     * @Route("/new", name="broker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $broker = new Broker();
        $contact = new Contact();        
        
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        $contactForm = $this->createForm(ContactFormType::class, $contact);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/new.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact'=>$contactForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="broker_show", methods={"GET"})
     */
    public function show(Broker $broker): Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactFormType::class, $contact);
        return $this->render('broker/show.html.twig', [
            'broker' => $broker,
            'contact'=> $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="broker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Broker $broker): Response
    {
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        $contact = new Contact();
        $contactForm = $this->createForm(ContactFormType::class, $contact);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/edit.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contactForm' => $contactForm->createView(),
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
