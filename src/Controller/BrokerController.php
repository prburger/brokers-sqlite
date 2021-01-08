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
use App\Repository\SupplierRepository;
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
        //$broker->setId(0);
       
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        $contactForm = $this->createForm(ContactFormType::class, new Contact());
    
        
        if ($form->isSubmitted() && $form->isValid()) {
            //$contact = $contactForm->getData();        
            $entityManager = $this->getDoctrine()->getManager(); 
            //$entityManager->persist($contact);
               
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
     * @Route("/{id}", name="broker_newCustomer", methods={"GET", "POST"})
    */
    public function newCustomer(Request $request, Broker $broker)
    {
        $customer = new Customer();
        $customer->setDateAdded(new \DateTime());
        $customer->setDateEdited(new \DateTime());
        $customer->setContact(new Contact());
        // $customer->setOwnerId($broker->getId());
        $form = $this->createForm(CustomerType::class, $customer);
        
        $contactForm = $this->createForm(ContactFormType::class, $customer->getContact());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $broker->addCustomer($customer);
            $entityManager = $this->getDoctrine()->getManager();            
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'contact'=>$contactForm->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="broker_show", methods={"GET", "POST"})
     */
    public function show(Broker $broker): Response
    {
        $contactForm = $this->createForm(ContactFormType::class, $broker->getContact());

        $form = $this->createForm(BrokerType::class, $broker);
        
        return $this->render('broker/show.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact'=> $contactForm->createView(),
            'messages' => $broker->getMessages(),
            'notes' => $broker->getNotes(),            
            'suppliers' => $broker->getSuppliers(),
            'customers' => $broker->getCustomers(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="broker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Broker $broker): Response
    {
   
        $contactForm = $this->createForm(ContactFormType::class, $broker->getContact());
        $contactForm->handleRequest($request);

        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);
                
        if ($form->isSubmitted() && $form->isValid()) {
            $broker->setDateEdited(new \DateTime());          
            //$this->getDoctrine()->getManager()->persist($contactForm->getData());          
            $this->getDoctrine()->getManager()->persist($broker);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/edit.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact' => $contactForm->createView(),
            'messages' => $broker->getMessages(),
            'notes' => $broker->getNotes(),            
            'suppliers' => $broker->getSuppliers(),
            'customers' => $broker->getCustomers(),
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
