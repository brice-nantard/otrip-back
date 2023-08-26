<?php

 namespace App\Form;

 use App\Entity\User;
 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class UserType extends AbstractType
 {
     public function buildForm(FormBuilderInterface $builder, array $options): void
     {
         $builder
             ->add('alias')
             ->add('email')
             ->add('password')
             ->add('roles', ChoiceType::class, [
                 'label' => 'Rôles',
                 'choices' => [
                     
                     'Utilisateur' => ["ROLE_USER"]
                     ,
                     'Administrateur' => ["ROLE_ADMIN"]
                     ,
                 ],
                 // choix multiple
                 'multiple' => true,
                 // checkboxes
                 'expanded' => true,
             ])
             
         ;
     }

     public function configureOptions(OptionsResolver $resolver): void
     {
         $resolver->setDefaults([
             'data_class' => User::class,
         ]);
     }
 }