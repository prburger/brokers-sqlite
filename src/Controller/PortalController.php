<?php

namespace App\Controller;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\SupplierRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal")
 */

//  * @IsGranted("ROLE_USER")

class PortalController extends AbstractController
{
    /**
    * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="portal_index")
    *      
    */ 

    public function index(
        BrokerRepository $brokerRepository,
        ProductRepository $productRepository,
        CustomerRepository $customerRepository,
        SupplierRepository $supplierRepository): Response
    { 
        return $this->render('portal/index.html.twig', [
            'controller_name' => 'PortalController',
            'brokers' => $brokerRepository->findAll(),
            'products' => $productRepository->findAll(),
            'suppliers' => $supplierRepository->findAll(),
            'customers' => $customerRepository->findAll(),
            'broker_id'=> $this->getUser()->getBroker()->getId(),
            'broker'=> $this->getUser()->getBroker()
            
        ]);
    }
}
