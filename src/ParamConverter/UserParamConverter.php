<?php declare(strict_types=1);

namespace Demontpx\UserBundle\ParamConverter;

use Demontpx\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class UserParamConverter implements ParamConverterInterface
{
    /** @var UserProviderInterface */
    private $userProvider;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $username = $request->get($name);

        try {
            $user = $this->userProvider->loadUserByUsername($username);
        } catch (UsernameNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        }

        $request->attributes->set($name, $user);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === UserInterface::class;
    }
}
