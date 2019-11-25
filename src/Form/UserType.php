<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Form;

use Demontpx\UserBundle\Model\AbstractUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
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
            $builder->add('roleList', ChoiceType::class, [
                'choices' => array_flip($this->roleList),
                'multiple' => true,
                'required' => false,
                'label' => 'demontpx_user.form.roles',
            ]);
        }

        $builder->add('enabled', CheckboxType::class, [
            'label' => 'demontpx_user.enabled',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AbstractUser::class,
        ]);
    }
}
