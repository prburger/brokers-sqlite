<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\MessageRepository;
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
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
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
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo
    ): Response
    {
        $message = new Message();
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
            'brokers'=> $brokers ? $brokers : null,
            'suppliers'=> $suppliers ? $suppliers : null,
            'customers'=> $customers ? $customers : null,
        ]);
    }
  
    /**
     * @Route("/{id}/addBroker", name="message_addBroker", methods={"GET","POST"})
    */
    public function addBroker(Request $request, BrokerRepository $repo, Message $message, string $id): Response
    {
        $message->addBroker($repo->find($id));
        return $this->redirectToRoute('message_index');
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
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
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        $brokers = $brokerRepo->findAll();
        $customers = $customerRepo->findAll();
        $suppliers = $supplierRepo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $brokers ? $brokers : null,
            'suppliers'=> $suppliers ? $suppliers : null,
            'customers'=> $customers ? $customers : null,
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
}
