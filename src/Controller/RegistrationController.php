<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 06/02/2018
 * Time: 10:14
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller;

use App\Form\SignupType;
use App\Entity\User;
use App\Handlers\Interfaces\RegistrationHandlerInterfaces;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class RegistrationController extends Controller
{
    private $_formFactory;
    private $_registerHandler;

    /**
     * RegistrationController constructor.
     *
     * @param FormFactoryInterface          $_formFactory
     * @param RegistrationHandlerInterfaces $_registerHandler
     */
    public function __construct(
        FormFactoryInterface $_formFactory,
        RegistrationHandlerInterfaces $_registerHandler
    ) {
        $this->_formFactory = $_formFactory;
        $this->_registerHandler = $_registerHandler;
    }

    /**
     * Envoie les données pour la création d'un User
     *
     * @param Request $request
     *
     * @Route("/signup", name="security_signup")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->_formFactory->create(SignupType::class, $user)
            ->handleRequest($request);

        if ($this->_registerHandler->handle($form)) {
            $this->addFlash('success', 'Merci pour votre inscription.');
            return $this->redirectToRoute('login');
        }

        return $this->render(
            'security/signup.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
