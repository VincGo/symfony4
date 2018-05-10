<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 06/02/2018
 * Time: 10:14
 */

namespace App\Controller;

use App\Form\SignupType;
use App\Entity\User;
use App\Handlers\Interfaces\RegistrationHandlerInterfaces;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    private $formFactory;
    private $registerHandler;

    public function __construct(
        FormFactoryInterface $formFactory,
        RegistrationHandlerInterfaces $registerHandler
    ){
        $this->formFactory = $formFactory;
        $this->registerHandler = $registerHandler;
    }

    /**
     * @Route("/signup", name="security_signup")
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->formFactory->create(SignupType::class, $user)
                                  ->handleRequest($request);
        if ($this->registerHandler->handle($form)) {
            $this->addFlash('success', 'Merci pour votre inscription.');
            return $this->redirectToRoute('login');
        }

        return $this->render('security/signup.html.twig',
            array('form' => $form->createView())
        );
    }
}