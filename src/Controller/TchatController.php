<?php
namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use dateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TchatController extends Controller{
    /**
     * @Route("/tchat")
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tchatAction(sessionInterface $session, Request $request){
        $login = $session->get('login');
        $idUser = $session->get('idUser');

        if($request->request->has('submit')){
            $messageTchat = $request->get('message');
            $em = $this->getDoctrine()->getManager();

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($idUser);

            $message = new message();
            $message->setMessage($messageTchat);
            $message->setDate(new dateTime());
            $message->setUser($user);
            $em->persist($message);
            $em->flush();
        }

        $message = $this -> getDoctrine()
            ->getRepository(Message::class)
            ->findAll();

        if($message){
            return $this->render('tchat.html.twig', array(
                'login' => $login,
                'messages' => $message
                ));
        }
        return $this->render('tchat.html.twig', array(
            'login' => $login,
            'messages' => $message
        ));
    }
}