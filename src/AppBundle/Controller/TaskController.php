<?php 

// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller{

    /**
     * @Route("/registertask", name="task_registration")
     */
    public function newAction(Request $request){
        // just setup a fresh $task object (remove the dummy data)
        $task = new Task();
        $session = $this->get('session');

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($em->getRepository('AppBundle:User')->find($session->get('user')->getId()));

        $tasks = $user->getTasks();
        // $em = $this->getDoctrine()->getManager();
        // $user = $em->getRepository('AppBundle:User')->find($session->get('user')->getId());

        // $repository = $this->getDoctrine()->getRepository(Task::class);
        // $query = $repository->createQueryBuilder('t')
        // ->where('t.user_id = ?1')
        // ->setParameters(array(1 => $user))
        // ->getQuery();

        // $tasks = $query->getResult();

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            // We obtain the forms information and save it in $task
            $task = $form->getData();

            // you can fetch the EntityManager via $this->getDoctrine()
            // or you can add an argument to your action: createAction(EntityManagerInterface $em)
            
            $user = $em->getRepository('AppBundle:User')->find($session->get('user')->getId());
            $task->setUser($user);

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($task);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute('task_registration');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
            'tasks' => $tasks
            // 'user' => $session->get('user')
        ));
    }

}

?>