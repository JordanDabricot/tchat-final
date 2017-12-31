<?php
namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller{
    /**
     * @Route("/login")
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, sessionInterface $session){
        if($session->get('login')){
            return $this->redirect('/tchat');
        }else {
            if ($request -> request -> has("submit")){
                $login = $request->get('login');
                $password = sha1($request->get('password'));
                $user = $this -> getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy([
                        'login' => $login,
                        'password' => $password
                    ]);
                if($user){
                    $session->set('login', $user->getLogin());
                    $session->set('idUser', $user->getId());
                    return $this->redirect('/tchat');
                }
            }
        }
        return $this->render('login.html.twig');
    }
}