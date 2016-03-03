<?php

namespace Demontpx\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

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

    /**
     * @param array $roleList
     */
    public function __construct(array $roleList)
    {
        $this->roleList = $roleList;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, [
            'label' => 'demontpx_user.username',
            'translation_domain' => 'FOSUserBundle',
        ]);
        $builder->add('fullName', null, [
            'label' => 'demontpx_user.full_name',
            'translation_domain' => 'FOSUserBundle',
        ]);
        $builder->add('email', null, [
            'label' => 'demontpx_user.email',
            'translation_domain' => 'FOSUserBundle',
        ]);
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'demontpx_user.form.new_password',
                'translation_domain' => 'FOSUserBundle',
            ],
            'second_options' => [
                'label' => 'demontpx_user.form.confirm_password',
                'translation_domain' => 'FOSUserBundle',
            ],
            'required' => false,
        ]);

        if (count($this->roleList) != 0) {
            $builder->add('roles', ChoiceType::class, array(
                'choices' => array_flip($this->roleList),
                'multiple' => true,
                'required' => false,
                'label' => 'demontpx_user.form.roles',
                'translation_domain' => 'FOSUserBundle',
            ));
        }
    }
}
