<?php 

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\TaskForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller{

    /**
     * @Route("/registertask", name="task_registration")
     */
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');

        // obtengo el usuario
        $userid = $session->get('user')->getId();
        $user = $em->getRepository('AppBundle:User')->find($userid);

        // defino nueva tarea
        $task = new Task();

        $form = $this->createForm(new TaskForm(), $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                
                
                $task->setUser($user);
                $em->persist($task);
                $em->flush();

                // $user->addTask($task);
                return $this->render('default/tasks/list.html.twig', array(
                    'tasks' => $user->getTasks()
                ));
                // return $this->redirectToRoute('task_registration');
            } catch (\Symfony\Component\Debug\Exception\FatalErrorException $e) {
                return new Response($e);
            }
        }

        // obtengo tasks del usuario en sesion
        $tasks = $user->getTasks();

        // rendereo vista
        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
            'tasks' => $tasks
            // 'user' => $session->get('user')
        ));
    }

}

?>