<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(TestRepository $vr): Response
    {
        $tests = $vr->findAll();
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController/index',
            'tests' => $tests,
        ]);
    }

    /**
     * @Route("/test/add", name="test_add")
     */
    public function addTest(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('test/add.html.twig', [
            'controller_name' => 'TestController/add',
            'form' => $form->createView(),
        ]);
    }
}
