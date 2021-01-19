<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Note;
use App\Entity\Supplier;
use App\Form\NoteType;
use App\Repository\BrokerRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="note_index", methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page":"1", "_format"="html"}, methods="GET", name="note_index_paginated")
     */
    public function index(Request $_request, int $page = 1, string $_format="html", NoteRepository $repository): Response
    {
        $pageData = $repository->findLatest($page);

        return $this->render('note/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
        ]);
    }

    /**
     * @Route("/new", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $note = new Note();
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($note->getBroker());
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_edit', array('id'=>$note->getId()));
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/broker/{broker}", name="note_broker", methods={"GET","POST"})
     */
    public function broker(Request $request, Broker $broker): Response
    {
        $note = new Note();
        $broker->addNote($note);
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($broker);            
            $entityManager->flush();

            return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'broker_id'=>$broker->getId()
        ]);
    }

    /**
     * @Route("/customer/{customer}", name="note_customer", methods={"GET","POST"})
     */
    public function customer(Request $request, Customer $customer): Response
    {
        $note = new Note();
        $note->setCustomer($customer);
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'customer_id'=>$customer->getId()
        ]);
    }

    /**
     * @Route("/supplier/{supplier}", name="note_supplier", methods={"GET","POST"})
     */
    public function supplier(Request $request, Supplier $supplier): Response
    {
        $note = new Note();
        $note->setSupplier($supplier);
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'supplier_id'=>$supplier->getId()
        ]);
    }

    /**
     * @Route("/{id}", name="note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/note/{note}/broker/{broker}/edit", name="note_editBroker", methods={"GET","POST"})
     */
    public function editBroker(Request $request, Note $note, Broker $broker): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $note = $form->getViewData();
            $note->setBrokerId($broker->getID());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'broker_id'=>$broker->getId()
        ]);
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response
    {
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_index');
    }

     /**
     * @Route("/remove/{note}/broker/{broker}", name="note_removeBroker", methods={"GET","POST"})
    */
    public function removeBroker(Note $note, Broker $broker): Response
    {
        $broker->removeNote($note);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('broker_edit', array('id'=>$broker->getId()));
    }

}
