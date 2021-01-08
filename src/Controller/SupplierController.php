<?php

namespace App\Controller;

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
        $supplier->setId(0);
        $supplier->setContact(new Contact());

        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        $contactForm = $this->createForm(ContactFormType::class,$supplier->getContact());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'contact' => $contactForm->createView(),
            'messages'=>$supplier->getMessages(),
            'notes'=>$supplier->getNotes(),
            'products'=>$supplier->getProducts()
        ]);
    }

    /**
     * @Route("/{id}", name="supplier_show", methods={"GET"})
     */
    public function show(Supplier $supplier): Response
    {
        $contactForm = $this->createForm(ContactFormType::class, $supplier->getContact());

        $form = $this->createForm(SupplierType::class, $supplier);
        
        return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            'contact'=> $contactForm->createView(),
            'messages' => $supplier->getMessages(),
            'notes' => $supplier->getNotes(),            
            // 'suppliers' => $supplier->getSuppliers(),
            //'customers' => $supplier->getCustomers(),
        ]);
        /* return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier,
        ]); */
    }

    /**
     * @Route("/{id}/edit", name="supplier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Supplier $supplier): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
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
}
