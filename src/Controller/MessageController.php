<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Message;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Form\BrokerType;
use App\Form\BrokersEmbeddedFormType;
use App\Form\CustomerType;
use App\Form\DataTransformer\BrokerArrayToStringTransformer;

use App\Form\MessageType;
use App\Form\SupplierType;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\MessageRepository;
use App\Repository\ProductRepository;
use App\Repository\SupplierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page":"1", "_format"="html"}, methods="GET", name="message_index_paginated")
     */
    public function index(Request $_request, int $page = 1, string $_format="html", MessageRepository $repository): Response
    {
        $pageData = $repository->findLatest($page);

        return $this->render('message/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
        ]);
    }

    /**
     * @Route("/{broker_id}/new", name="message_new", methods={"GET","POST"})
     * @Route("/new", name="message_new_no_id", methods={"GET","POST"})
     */
    public function new(
        Request $request, 
        ?int $broker_id,
        BrokerRepository $brokerRepo,
        CustomerRepository $customerRepo,        
        SupplierRepository $supplierRepo
        ): Response
        {
            $message = new Message();   
            $message->setId(0);
            
            if($broker_id != null)
            {
                $message->setSentBy($brokerRepo->find($broker_id)->getName());
            }
            
            $brokerSelection = $brokerRepo->findWithoutId($broker_id);
            $customerSelection = $customerRepo->findAll();
            $supplierSelection = $supplierRepo->findAll();
            
            $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerSelection,
                      'customerSelection'=>$customerSelection,
                      'supplierSelection'=>$supplierSelection));  
            
            $form->handleRequest($request);
                            
             if ($form->isSubmitted() && $form->isValid()) {            
                
                $entityManager = $this->getDoctrine()->getManager();
                $message = $form->getViewData();
                
                $message->setBrokers($message->brokerSelection);
                $message->setCustomers($message->customerSelection);
                $message->setSuppliers($message->supplierSelection);
                $entityManager->persist($message);   

                $entityManager->flush();
                
                return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
            }

            return $this->render('message/new.html.twig' , [
                'form' => $form->createView(),
                'brokers'=>$message->getBrokers(),
                'customers'=>$message->getCustomers(),
                'suppliers'=>$message->getSuppliers(),
                'broker_id'=>$broker_id

            ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        // $form->handleRequest($request);
        return $this->render('message/show.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request, 
        Message $message,  
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo): Response
    {
        
        $broker = $brokerRepo->findByName($message->getSentBy());
        
        $brokerSelection = $brokerRepo->findWithoutName($message->getSentBy());                
        for($i=0; $i<count($brokerSelection); $i++)
        {
            if($message->getBrokers()->contains($brokerSelection[$i])){
              array_splice($brokerSelection, $i,1);
            }
        }
        
        $customerSelection = $customerRepo->findAll();
        for($i=0; $i<count($customerSelection); $i++)
        {
            if($message->getCustomers()->contains($customerSelection[$i])){         
             array_splice($customerSelection, $i,1);
            }
        }        

        $supplierSelection = $supplierRepo->findAll();
        for($i=0; $i<count($supplierSelection); $i++)
        {
            if($message->getSuppliers()->contains($supplierSelection[$i])){
              array_splice($supplierSelection, $i,1);
            }
        }

        $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerSelection,
                      'customerSelection'=>$customerSelection,
                      'supplierSelection'=>$supplierSelection));  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message = $form->getViewData();
                
            foreach($message->brokerSelection as $broker){
                $message->addBroker($broker);
            }
            foreach($message->customerSelection as $customer){
                $message->addCustomer($customer);
            }
            foreach($message->supplierSelection as $supplier){
                $message->addSupplier($supplier);
            }
                        
            $entityManager->persist($message);   
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $message->getBrokers(),
            'suppliers'=> $message->getSuppliers(),
            'customers'=> $message->getCustomers(),
            'broker_id'=>$broker[0]->getId()
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * @Route("/{customer_id}/new", name="message_newCustomer", methods={"GET","POST"})
     */
    public function newCustomer(
        Request $request, 
        ?int $customer_id,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo
    ): Response
    {
        $message = new Message();
        $message->setId("1");
        $broker = $brokerRepo->find($broker_id);

        $message->setSentBy($broker->getName());

        $brokers = $brokerRepo->findAll();
        $customers = $customerRepo->findAll();
        $suppliers = $supplierRepo->findAll();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('broker_edit', array('id'=>$broker_id));
        }

        return $this->render('message/new.html.twig' , [
            'message' => $message,
            'form' => $form->createView(),
            'messages'=>$customer->getMessages(),
            'brokers'=> $brokers ? $brokers : null,
            'suppliers'=> $suppliers ? $suppliers : null,
            'customers'=> $customers ? $customers : null,
        ]);
    }

    /**
     * @Route("/{supplier_id}/new", name="message_newSupplier", methods={"GET","POST"})
     */
    public function newSupplier(
        Request $request, 
        ?int $supplier_id,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo
    ): Response
    {
        $message = new Message();
        $message->setId("1");
        // $supplier = $supplierRepo->find($supplier_id);
        // $message->setSentBy($supplier->getName());

        $brokers = $brokerRepo->findAll();
        $customers = $customerRepo->findAll();
        // $suppliers = $supplierRepo->findAll();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('supplier_edit', array('id'=>$supplier_id));
        }

        return $this->render('message/new.html.twig' , [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $brokers ? $brokers : null,
            // 'suppliers'=> $suppliers ? $suppliers : null,
            'customers'=> $customers ? $customers : null,
        ]);
    }

       /**
     * @Route("/{product_id}/new", name="message_newProduct", methods={"GET","POST"})
     */
     public function newProduct(
        Request $request, 
        ?int $product_id,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo
    ): Response
    {
        $message = new Message();
        $message->setId("1");
        $product = $productRepo->find($product_id);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('product_edit', array('id'=>$product_id));
        }

        return $this->render('message/new.html.twig' , [
            'message' => $message,
            'form' => $form->createView(),
            // 'notes'=> $product->getNotes(),
            // 'specifications'=> $product->getSpecifications(),
        ]);
    }
  

    /**
     * @Route("/remove/{message}/broker/{broker}", name="message_removeBroker", methods={"GET","POST"})
    */
    public function removeBroker(Message $message, Broker $broker): Response
    {
        $message->removeBroker($broker);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

    /**
     * @Route("/remove/{message}/customer/{customer}", name="message_removeCustomer", methods={"GET","POST"})
    */
    public function removeCustomer(Message $message, Customer $customer): Response
    {
        $message->removeCustomer($customer);        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
    }

    /**
     * @Route("/remove/{message}/supplier/{supplier}", name="message_removeSupplier", methods={"GET","POST"})
    */
    public function removeSupplier(Message $message, Supplier $supplier): Response
    {
        $message->removeSupplier($supplier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
    }
}
