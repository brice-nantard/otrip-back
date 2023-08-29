<?php



 namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


 class UserType extends AbstractType
 {
     public function buildForm(FormBuilderInterface $builder, array $options): void
     {
         $builder

             ->add('alias', TextType::class)
             ->add('email', EmailType::class)
             ->add('roles', ChoiceType::class, [
                         'required' => true,
                         'multiple' => true,
                         'expanded' => true,
                         'choices'  => [
                             'User' => 'ROLE_USER',
                             'Admin' => 'ROLE_ADMIN',
                         ],
                     ])
 
            ->add('Password', RepeatedType::class, array(
                      'type' => PasswordType::class,
                      'first_options' => array('label' => 'Mot de passe'),
                      'second_options' => array('label' => 'Confirmation du mot de passe'),
                  ))
                  ->add('Enregistrer', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn-primary btn-block']]);

                }

     public function configureOptions(OptionsResolver $resolver): void
     {
         $resolver->setDefaults([
             'data_class' => User::class,
         ]);
     }
 }