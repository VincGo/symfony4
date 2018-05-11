<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 30/01/2018
 * Time: 09:21
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class SecurityController extends AbstractController
{
    /**
     * Authentification de l'utilisateur géré par security
     *
     * @param Request             $request
     * @param AuthenticationUtils $authUtils
     *
     * @Route("/login", name="login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * Déconnexion
     *
     * @throws \Exception
     *
     * @Route("/logout", name="logout")
     *
     * @return void
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
