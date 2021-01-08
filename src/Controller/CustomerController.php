<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Customer;
use App\Form\ContactFormType;
use App\Form\CustomerType;
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
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="customer_index")
      * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="customer_index_paginated")
     * @Cache(smaxage="10")    
    */
    public function index(Request $_request, int $page = 1, string $_format="html", CustomerRepository $repository): Response
    {        
        $pageData = $repository->findLatest($page);

        return $this->render('customer/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
        ]);
    }

    /**
     * @Route("/new", name="customer_new", methods={"GET","POST"})
     */
    public function new(
        Request $request, 
        SupplierRepository $supplierRepo, 
        BrokerRepository $brokerRepo, 
        MessageRepository $messageRepo, 
        NoteRepository $noteRepo
    ): Response
    {

        $customer = new Customer();
        $customer->setId(0);          
        $customer->setContact(new Contact());  
        
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        $contactForm = $this->createForm(ContactFormType::class,$customer->getContact());
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'contact'=>$contactForm->createView(),          
            'messages' => $customer->getMessages(),
            'notes' => $customer->getNotes(),        
        ]);
    }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     */
    public function show(
        Customer $customer,
        MessageRepository $messageRepo,
        NoteRepository $noteRepo,
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo): Response
    {
        $contactForm = $this->createForm(ContactFormType::class, $customer->getContact());
        $messages = $messageRepo->findByName($customer->getName());
        $notes = $noteRepo->findAll($customer->getId());
        $suppliers = $supplierRepo->findAll($customer->getId());
        $customers = $customerRepo->findAll($customer->getId());

        $form = $this->createForm(CustomerType::class, $customer);
        
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'contact'=> $contactForm->createView(),
            'messages' => $customer->getMessages(),
            'notes' => $customer->getNotes(),            
            'suppliers' => $customer->getSuppliers(),
            'brokers' => $customer->getBrokers(),
        ]);

        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_index');
    }
}
