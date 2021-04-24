<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/address", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-addresse", name="account_address_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class,$address)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $manager->persist($address);
            $manager->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-addresse/{id}", name="account_address_edit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit($id,Request $request, EntityManagerInterface $manager): Response
    {
        $address = $manager->getRepository(Address::class)->findOneById($id);
        if (!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class,$address)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-addresse/{id}", name="account_address_delete")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete($id, EntityManagerInterface $manager): Response
    {
        $address = $manager->getRepository(Address::class)->findOneById($id);
        if ($address && $address->getUser() == $this->getUser()){
            $manager->remove($address);
            $manager->flush();
        }
        return $this->redirectToRoute('account_address');
    }
}
