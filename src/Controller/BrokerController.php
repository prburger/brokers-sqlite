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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of 9352042... Revert "500 error on heroku"
        $broker->setDateAdded(new \DateTime());
        $broker->setDateEdited(new \DateTime());
       // $broker->setId(0);
=======
        $broker->setId(0);
>>>>>>> parent of 4f640df... 500 error on heroku
       
        $broker->setContact(new Contact());
        
=======
        //$broker->setId(0);
       
>>>>>>> parent of f3133de... 500 error on heroku
=======
        //$broker->setId(0);
       
>>>>>>> parent of f3133de... 500 error on heroku
=======
        //$broker->setId(0);
       
>>>>>>> parent of f3133de... 500 error on heroku
=======
        $broker->setId(0);
        $broker->setDateAdded(new \DateTime());
        $broker->setDateEdited(new \DateTime());       
          
        $broker->setContact(new Contact());  
        $broker->getContact()->setDateAdded(new \DateTime());
        $broker->getContact()->setDateEdited(new \DateTime());       
        $messages = $messageRepo->findAll($broker->getId());
        $notes = $noteRepo->findAll($broker->getId());
        $suppliers = $supplierRepo->findAll($broker->getId());
        $customers = $customerRepo->findAll($broker->getId());
>>>>>>> parent of 22afb08 (fixed GUI, added customers, modified entities)
        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        $contactForm = $this->createForm(ContactFormType::class, $broker->getContact());
    
        
        if ($form->isSubmitted() && $form->isValid()) {
            //$contact = $contactForm->getData();        
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($broker->getContact());
               
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/new.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact'=>$contactForm->createView(),          
<<<<<<< HEAD
=======
            'messages' => $messages ? $messages :null,
            'notes' => $notes ? $notes : null,            
            'suppliers' => $suppliers ? $suppliers : null,
            'customers' => $customers ? $customers : null,
>>>>>>> parent of 22afb08 (fixed GUI, added customers, modified entities)
        ]);
    }

    /**
     * @Route("/{id}", name="broker_show", methods={"GET"})
     */
<<<<<<< HEAD
    public function show(Broker $broker): Response
=======
    public function show(Broker $broker, 
    MessageRepository $messageRepo,
    NoteRepository $noteRepo,
    SupplierRepository $supplierRepo,
    CustomerRepository $customerRepo): Response
>>>>>>> parent of 22afb08 (fixed GUI, added customers, modified entities)
    {
        // $contact = $contactRepo->find($broker->getContact()->getId());
        $contactForm = $this->createForm(ContactFormType::class, $broker->getContact());
        $messages = $messageRepo->findAll($broker->getId());
        $notes = $noteRepo->findAll($broker->getId());
        $suppliers = $supplierRepo->findAll($broker->getId());
        $customers = $customerRepo->findAll($broker->getId());

        $form = $this->createForm(BrokerType::class, $broker);
        
        return $this->render('broker/show.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact'=> $contactForm->createView(),
            'messages' => $messages ? $messages :null,
            'notes' => $notes ? $notes : null,            
            'suppliers' => $suppliers ? $suppliers : null,
            'customers' => $customers ? $customers : null,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="broker_edit", methods={"GET","POST"})
     */
<<<<<<< HEAD
    public function edit(Request $request, Broker $broker): Response
=======
    public function edit(Request $request, Broker $broker, 
    MessageRepository $messageRepo,
    NoteRepository $noteRepo,
    SupplierRepository $supplierRepo,
    CustomerRepository $customerRepo): Response
>>>>>>> parent of 22afb08 (fixed GUI, added customers, modified entities)
    {
   
        $contactForm = $this->createForm(ContactFormType::class, $broker->getContact());
        $contactForm->handleRequest($request);

        $form = $this->createForm(BrokerType::class, $broker);
        $form->handleRequest($request);

        $messages = $messageRepo->findByName($broker->getName());
        $notes = $noteRepo->findAll($broker->getId());
        $suppliers = $supplierRepo->findAll($broker->getId());
        $customers = $customerRepo->findAll($broker->getId());
                
        if ($form->isSubmitted() && $form->isValid()) {
            $broker->setDateEdited(new \DateTime());          
            $this->getDoctrine()->getManager()->persist($contactForm->getData());            
        
            $this->getDoctrine()->getManager()->persist($broker);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('broker_index');
        }

        return $this->render('broker/edit.html.twig', [
            'broker' => $broker,
            'form' => $form->createView(),
            'contact' => $contactForm->createView(),
            'messages' => $messages ? $messages :null,
            'notes' => $notes ? $notes : null,            
            'suppliers' => $suppliers ? $suppliers : null,
            'customers' => $customers ? $customers : null,
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
