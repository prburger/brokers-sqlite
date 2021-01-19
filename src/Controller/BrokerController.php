<?php

namespace App\Controller;

use App\Entity\Broker;
use\App\Entity\Contact;
use\App\Entity\Message;
use\App\Entity\Note;
use\App\Entity\Supplier;
use\App\Entity\Customer;

use App\Form\BrokerType;
use\App\Form\ContactFormType;
use\App\Form\MessageType;
use\App\Form\NoteType;
use\App\Form\SupplierType;
use\App\Form\CustomerType;

use App\Repository\BrokerRepository;
use App\Repository\ContactRepository;
use App\Repository\CustomerRepository;
use App\Repository\MessageRepository;
use App\Repository\NoteRepository;
use App\Repository\SupplierRepository
;
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
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page":"1", "_format"="html"}, methods="GET", name="broker_index_paginated")
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
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {                  
            $entityManager = $this->getDoctrine()->getManager();             
            $entityManager->persist($broker);
            $entityManager->flush();
            return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
        }

        return $this->render('broker/new.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),        
            'edit_state'=>false,
            'fresh_state'=>true
        ]);
    }

    /**
     * @Route("/{id}", name="broker_show", methods={"GET"})
     */
    public function show(Broker $broker): Response
    {
        $form = $this->createForm(BrokerType::class, $broker);
        
        return $this->render('broker/show.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>false
        ]);
    }

    /**
     * @Route("/{id}/edit", name="broker_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request, 
        Broker $broker): Response
    {
        
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();  
            
            $broker->setDateEdited(new \DateTime());          
           
            $entityManager->persist($broker);
            $entityManager->flush();
            return $this->redirectToRoute('broker_edit', array('customer'=>$customer, 'broker'=>$broker));
        }

        return $this->render('broker/edit.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'edit_state'=> true,
            'fresh_state'=>false
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

    /**
     * @Route("/customer/{customer}/broker/{broker}/remove", name="broker_removeCustomer", methods={"GET","POST"})
    */
    public function removeCustomer(Customer $customer, Broker $broker): Response
    {
        $broker->removeCustomer($customer);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

    /**
     * @Route("/supplier/{supplier}/broker/{broker}/remove", name="broker_removeSupplier", methods={"GET","POST"})
    */
    public function removeSupplier(Supplier $supplier, Broker $broker): Response
    {
        $broker->removeSupplier($supplier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

    /**
     * @Route("/message/{message}/broker/{broker}/remove", name="broker_removeMessage", methods={"GET","POST"})
    */
    public function removeMessage(Message $message, Broker $broker): Response
    {
        $broker->removeMessage($message);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($message);
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

    /**
     * @Route("/note/{note}/broker/{broker}/remove", name="broker_removeNote", methods={"GET","POST"})
    */
    public function removeNote(Note $note, Broker $broker): Response
    {
        $broker->removeNote($note);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }
}
