<?php 

namespace AppBundle\Controller;

use AppBundle\Form\LoginForm;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller{

	/**
     * @Route("/login", name="user_login")
     */
	public function ingresoDeUsuario(Request $request){
		// 1) build the form
        $form = $this->createForm(new LoginForm());

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$repository = $this->getDoctrine()->getRepository(User::class);
            $query = $repository->createQueryBuilder('u')
            ->where('u.email = ?1 and u.password = ?2')
            ->setParameters(array(1 => $form->get('email')->getData(), 2 => $form->get('plainPassword')->getData()))
            ->getQuery();

            $user = $query->getResult();

            if(empty($user)){
                return $this->render(
                    'login/login.html.twig',
                    array('form' => $form->createView())
                );
            }

            $session = $this->get('session');
            $session->set('user', $user[0]);
            // $session->set('user', $user[0]->getUsername());
            // $session->set('user_id', $user[0]->getId());
            return $this->redirectToRoute('task_registration');
        }

        return $this->render(
            'login/login.html.twig',
            array('form' => $form->createView())
        );
    }
}
?>