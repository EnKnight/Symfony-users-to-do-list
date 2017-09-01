<?php 

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskForm extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('task', 'text', array(
                'attr' => ['class' => 'task_des'],
                'label' => 'Ingrese la tarea'))
            ->add('dueDate', 'date', array(
                'format' => 'dd-MM-yyyy',
                'label' => 'Configurar fecha',
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día')))
            ->add('save', 'submit', array('label' => 'Registrar Tarea'));
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            // 'data_class' => User::class,
        ));
    }

    public function getName(){
        return 'task_form';
    }

    public function getId(){
        return 'task-form';
    }
}

?>