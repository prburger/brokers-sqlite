<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Message;
use App\Entity\Note;
use App\Entity\Product;
use App\Form\CustomerType;
use\App\Form\ContactFormType;
use\App\Form\MessageType;
use\App\Form\NoteType;
use\App\Form\ProductType;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\MessageRepository;
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
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, methods="GET", name="customer_rss")
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
    public function new(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'fresh_state'=>true
        ]);
    }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     */
    public function show(Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>false
        ]);


        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request, 
        Customer $customer, 
        MessageRepository $messageRepo
        ): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);

            $entityManager->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'new'=>false,
            'form' => $form->createView(),
            'edit_state'=>true,
            'fresh_state'=>false
        ]);
    }

    /**
     * @Route("/broker/{broker}", name="customer_broker", methods={"GET","POST"})
     */
    public function broker(Request $request, Broker $broker): Response
    {
        $customer = new Customer();
        $broker->addCustomer($customer);
        
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true,

        ]);
    }

    /**
     * @Route("/{customer}/note", name="customer_note", methods={"GET","POST"})
     */
    public function note(Request $request, Customer $customer): Response
    {
        $note = new Note();
        $customer->addNote($note);
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'customer_id'=>$customer->getId(),
            'edit_state'=>true,
            'fresh_state'=>true
        ]);
    }

    /**
     * @Route("/{customer}/message", name="customer_message", methods={"GET","POST"})
    */
    public function message(
        Request $request, 
        Customer $customer,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo
    ): Response
    {
        $message = new Message();
        $message->setSentBy($customer->getName());
        $customer->addMessage($message);

        $brokerSelection = $brokerRepo->findAll();
        $customerSelection = $customerRepo->findWithoutId($customer->getId());
        $supplierSelection = $supplierRepo->findAll();
            
        $form = $this->createForm(MessageType::class,$message,
            array('brokerSelection'=>$brokerSelection,
                    'customerSelection'=>$customerSelection,
                    'supplierSelection'=>$supplierSelection));  

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);            
            $entityManager->flush();

            return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
        }

        return $this->render('message/new.html.twig' , [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=>$message->getBrokers(),
            'customers'=>$message->getCustomers(),
            'suppliers'=>$message->getSuppliers(),
            'customer_id'=>$customer->getId(),
            'fresh_state'=>true,
            'edit_state'=>true
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

    /**
     * @Route("/insert/{broker}", name="customer_insertBroker", methods={"GET","POST"})
    */
    public function insertBroker(Broker $broker): Response
    {
        $customer = new Customer();
        $customer->setBroker($broker);
        
        $form = $this->createForm(InsertCustomersType::class, $customer);
        $form->handleRequest($request);
        
        return $this->render('customer/selectlist.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true,

        ]);
    }

    /**
     * @Route("/{customer}/product", name="customer_product", methods={"GET","POST"})
    */
    public function product(Request $request, Customer $customer): Response
    {
        $product = new Product();
        $customer->addProduct($product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true
        ]);
    }
}
