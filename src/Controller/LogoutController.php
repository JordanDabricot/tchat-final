<?php
/**
 * Created by PhpStorm.
 * User: jordan
 * Date: 21/12/17
 * Time: 18:23
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends Controller {
    /**
     * @Route("/logout")
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout(SessionInterface $session){
        $session->clear();
        return $this->redirect('/');
    }
}