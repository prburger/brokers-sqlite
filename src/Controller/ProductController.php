<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Specification;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="product_index")
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, methods="GET", name="product_rss")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="product_index_paginated")
     * @Cache(smaxage="10")    
    */
    
    public function index(Request $_request, int $page = 1, string $_format="html", ProductRepository $repository): Response
    {        
        $pageData = $repository->findLatest($page);

        return $this->render('product/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
            'broker_id' => $this->getUser()->getBroker()->getId()
        ]);
    }

    /**
     * @Route("/{id}/specification", name="product_specification", methods={"GET","POST"})
     */
    public function specification(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('specification/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $user = $this->getUser();
        $product->setBrokerId($user->getBroker()->getId());

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'edit_state'=>false,
            'fresh_state'=>true
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'form'=>$form->createView(),
            'edit_state'=>false,
            'fresh_state'=>false
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDateEdited(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product); 
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'edit_state'=>true,
            'fresh_state'=>false
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
