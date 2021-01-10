<?php

namespace App\Controller;

use App\Entity\Specification;
use App\Form\SpecificationType;
use App\Repository\SpecificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/specification")
 */
class SpecificationController extends AbstractController
{
    /**
     * @Route("/", name="specification_index", methods={"GET"})
     */
    public function index(SpecificationRepository $specificationRepository): Response
    {
        return $this->render('specification/index.html.twig', [
            'specifications' => $specificationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="specification_new", methods={"GET","POST"})
     */
    public function new(Request $request, Product $product): Response
    {
        // $specification = new Specification();
        $form = $this->createForm(SpecificationType::class, $product->getSpecifications());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('specification_index');
        }

        return $this->render('product/newSpecifications.html.twig', [
            'specification' => $specification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specification_show", methods={"GET"})
     */
    public function show(Specification $specification): Response
    {
        return $this->render('specification/show.html.twig', [
            'specification' => $specification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="specification_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Specification $specification): Response
    {
        $form = $this->createForm(SpecificationType::class, $specification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specification_index');
        }

        return $this->render('specification/edit.html.twig', [
            'specification' => $specification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specification_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Specification $specification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($specification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specification_index');
    }
}
