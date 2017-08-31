<?php 

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('email', 'email')
            // ->add('username', 'text')
            ->add('plainPassword', 'password');
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            // 'data_class' => User::class,
        ));
    }

    public function getName(){
        return 'user';
    }
}

?>