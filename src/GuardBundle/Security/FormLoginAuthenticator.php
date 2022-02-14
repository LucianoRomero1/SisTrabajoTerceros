<?php

namespace GuardBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login_check') {
          return;
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
		//$coneccion = $request->request->get('_coneccion');
        //$host = '192.168.0.244';
        return [
            'username' => $username,
            'password' => $password/*,
			'dbname' => $coneccion,
			'host' => $host,*/
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $connection = $this->container
            ->get('doctrine')
            ->getManager()->getConnection();
        $params     = $connection->getParams();
        
        if ($connection->isConnected()) {
            $connection->close();
        }

        $params['user']   = $user;
        $params['password'] = $plainPassword;
	/*	$params['dbname'] = 'neosysmp';
		$params['host'] = '192.168.0.244';*/
        
		

        // Set up the parameters for the parent
        $connection->__construct(
                $params, $connection->getDriver(), $connection->getConfiguration(),
                $connection->getEventManager()
        );

        try {
            
            $connection->connect();
            
            if ( $user != 'shidalgo' && $user != 'pmautino' && $user != 'lromero'){
                $statement = $connection->prepare('set role ROL_USUARIO IDENTIFIED BY "MP987Basso"');
                $statement->execute();
            }
            } catch (\Exception $e) {
                // log and handle exception
                
                throw new BadCredentialsException();
            }
        return true;
            
        //$encoder = $this->container->get('security.password_encoder');
        //if ($encoder->isPasswordValid($user, $plainPassword)) {
        //    return true;
        //}
        //throw new BadCredentialsException();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->container->get('router')->generate('homepage');

        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
       $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

       $url = $this->container->get('router')->generate('login');

       return new RedirectResponse($url);
    }

    protected function getLoginUrl()
    {
        return $this->container->get('router')->generate('login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->container->get('router')->generate('homepage');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
