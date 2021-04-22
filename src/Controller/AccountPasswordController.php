<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/compte/modifier_mon_mot_de_passe", name="account_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();
            if ($encoder->isPasswordValid($user,$old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $pwd = $encoder->encodePassword($user,$new_pwd);
                $user->setPassword($pwd);
                $manager->flush();
            }
        }
        return $this->render('account/password.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
