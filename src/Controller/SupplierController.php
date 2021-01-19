<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Contact;
use App\Entity\Supplier;
use App\Form\SupplierType;
use\App\Form\ContactFormType;
use App\Repository\SupplierRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/supplier")
 */
class SupplierController extends AbstractController
{
   /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="supplier_index")
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, methods="GET", name="supplier_rss")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="supplier_index_paginated")
     * @Cache(smaxage="10")    
    */
    public function index(Request $_request, int $page = 1, string $_format="html", SupplierRepository $repository): Response
    {        
        $pageData = $repository->findLatest($page);

        return $this->render('supplier/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
        ]);
    }

    /**
     * @Route("/new", name="supplier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
        }

        return $this->render('supplier/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true,

        ]);
    }

    /**
     * @Route("/{id}", name="supplier_show", methods={"GET"})
     */
    public function show(Supplier $supplier): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        
        return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>false,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="supplier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Supplier $supplier): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();
            return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
        }

        return $this->render('supplier/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'edit_state'=>true,
            'fresh_state'=>false,
            ]);
    }

    /**
     * @Route("/{id}", name="supplier_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Supplier $supplier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supplier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('supplier_index');
    }

    /**
     * @Route("/broker/{broker}", name="supplier_broker", methods={"GET","POST"})
     */
    public function broker(Request $request, Broker $broker): Response
    {
        $supplier = new Supplier();
        // $supplier->setBroker($broker);
        $broker->addSupplier($supplier);
        
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->persist($broker);
            $entityManager->flush();

            return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
        }

        return $this->render('supplier/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true,

        ]);
    }

    /**
     * @Route("/remove/{supplier}/broker/{broker}", name="supplier_removeBroker", methods={"GET","POST"})
    */
    public function removeBroker(Supplier $supplier, Broker $broker): Response
    {
        $broker->removeSupplier($supplier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

    /**
     * @Route("/insert/{broker}", name="supplier_insertBroker", methods={"GET","POST"})
    */
    public function insertBroker(Broker $broker): Response
    {
        /* $broker->removeSupplier($supplier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush(); */
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }
}
