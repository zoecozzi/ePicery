<?php

namespace App\Form;

use App\Entity\CustomerAddress;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderType extends AbstractType
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $builder
            ->add('addresses', EntityType::class, [
                'label'=>'Sélectionnez une adresse de livraison',
                'required'=>true,
                'class'=>CustomerAddress::class,
                'choices'=>$user->getAdress(),
                'multiple'=>false,
                'expanded'=>true,
                'mapped'=>false,
                'attr'=>[
                    'class'=>'panier-adresse'
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label'=>'Valider ma commande',
                'attr'=>[
                    'class'=>'btn-panier-val'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           
        ]);
    }
}
