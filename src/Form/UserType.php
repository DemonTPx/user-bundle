<?php

namespace Demontpx\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserType
 *
 * @package   Demontpx\UserBundle\Form
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

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username');
        $builder->add('email');
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'first_options' => array('label' => 'New password'),
            'second_options' => array('label' => 'Confirm password'),
            'required' => false,
        ));

        if (count($this->roleList) != 0) {
            $builder->add('roles', 'choice', array(
                'choices' => $this->roleList,
                'multiple' => true,
                'required' => false,
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'user';
    }
}
