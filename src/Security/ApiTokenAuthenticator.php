<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

use App\Repository\ApiTokenRepository;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private $apiTokenRepo;

    public function __construct(ApiTokenRepository $apiTokenRepo)
    {
        $this->apiTokenRepo=$apiTokenRepo;
    }

    public function supports(Request $request)
    {
        // todo
        return $request->headers->has('Authorization') && 0 === strpos($request->headers->get('Authorization'), 'Bearer');
    }

    public function getCredentials(Request $request)
    {
        // todo
        $authorizationHeader= $request->headers->get('Authorization');
        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token=$this->apiTokenRepo->findOneBy(['token'=>$credentials]);
        if(!$token)
        {
            throw new CustomUserMessageAuthenticationException('Invalid API token');
            //return;
        }
        if($token->isExpired())
        {
            throw new CustomUserMessageAuthenticationException('Token expired');
        }
        return $token->getUser();
        // todo
        //dump($credentials);
        //die;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // todo
        //dump('check credentials');
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
        return new JsonResponse(['message'=>$exception->getMessageKey()], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
        return true;
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
