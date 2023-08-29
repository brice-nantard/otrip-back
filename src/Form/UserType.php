<?php



 namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use App\Form\DataTransformer\StringToJsonArrayTransformer;


 class UserType extends AbstractType
 {
     public function buildForm(FormBuilderInterface $builder, array $options): void
     {
         $builder
         ->add('alias', TextType::class)
             ->add('email', EmailType::class)
             ->add('roles', ChoiceType::class, [
                         
                         
                         'expanded' => true,
                         'choices'  => [
                             'User' => 'ROLE_USER',
                             'Admin' => 'ROLE_ADMIN'],
                             'required' => true,
                             'multiple' => true,
                     ])
 
            ->add('Password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Merci de saisir deux mots de passe identiques. ',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
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