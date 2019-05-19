<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

use App\Repository\UserRepository;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;

    private $router;

    private $csrfTokenManager;

    private $passwordEncoder;

    private $encodePass;

    use TargetPathTrait;

    public function __construct(UserRepository $userRepository, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager, SessionInterface $session, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository= $userRepository;

        $this->router=$router;

        $this->csrfTokenManager = $csrfTokenManager;

        $this->session = $session;

        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        //die('Our authenticator is alive!');
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token')
        ];
        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // todo
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token))
        {
            throw new InvalidCsrfTokenException();
        }

        //dd($this->userRepository->findOneBy(['email'=> $credentials['email'] ]) );

        //since email is unique checking by password can be skipped
        //and it must be skipped if it is coded and form brings uncoded pass
        return $this->userRepository->findOneBy(['email'=> $credentials['email'] ]);
        //return $this->userRepository->findOneBy(['email'=> $credentials['email'], 'password'=> $credentials['password']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        //dump($user);
        //dump($credentials['password']);
        //dump($user->getPassword());
        //dump( $this->passwordEncoder->isPasswordValid($user, $credentials['password']) );
        if($credentials['password']!=$user->getPassword())
        {
            $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        }
        //dump('passed');
        //if it got here then user is obtained, othervise it would escape back to login
        $credentials['username']=$user->getUsername();
        $this->session->set('logged_user', $credentials['username']);
        //return true needed because if it doesn't return true it considers that credentials are incorrect
        return true;
    }

    /*
    //remove this function to allow error messages, otherwise it blocks them
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
        //dd('Fail');
        //dump('failed autentication');
        //dump($exception);
    }
    */

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if($targetPath=$this->getTargetPath($request->getSession(), $providerKey) )
        {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('welcome'));
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
        return $this->router->generate('app_login');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('welcome'));
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
