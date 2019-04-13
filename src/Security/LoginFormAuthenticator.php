<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

use App\Repository\UserRepository;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository= $userRepository;
    }

    public function supports(Request $request)
    {
        //die('Our authenticator is alive!');
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // todo
        return [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // todo
        //dd($credentials);
        return $this->userRepository->findOneBy(['email'=> $credentials['email']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // todo
        //dd($user);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
        dd('Fail');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
        dd('Success');
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
