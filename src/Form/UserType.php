<?php

namespace Demontpx\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserType extends AbstractType
{
    /** @var array */
    private $roleList;

    public function __construct(array $roleList)
    {
        $this->roleList = $roleList;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, [
            'label' => 'demontpx_user.username',
        ]);
        $builder->add('fullName', null, [
            'label' => 'demontpx_user.full_name',
        ]);
        $builder->add('email', null, [
            'label' => 'demontpx_user.email',
        ]);
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'demontpx_user.form.new_password',
            ],
            'second_options' => [
                'label' => 'demontpx_user.form.confirm_password',
            ],
            'required' => false,
        ]);

        if (count($this->roleList) != 0) {
            $builder->add('roles', ChoiceType::class, array(
                'choices' => array_flip($this->roleList),
                'multiple' => true,
                'required' => false,
                'label' => 'demontpx_user.form.roles',
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'FOSUserBundle',
        ]);
    }
}
