<?php

namespace EngiShopBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Firewall\ExceptionListener as BaseExceptionListener;
use Symfony\Component\Security\Http\HttpUtils;
use Psr\Log\LoggerInterface;

class ExceptionListener extends BaseExceptionListener
{
    private $providerKey;

    public function __construct(SecurityContextInterface $context, AuthenticationTrustResolverInterface $trustResolver, HttpUtils $httpUtils, $providerKey, AuthenticationEntryPointInterface $authenticationEntryPoint = null, $errorPage = null, AccessDeniedHandlerInterface $accessDeniedHandler = null, LoggerInterface $logger = null)
    {
        $this->providerKey = $providerKey;
        parent::__construct($context, $trustResolver, $httpUtils, $providerKey, $authenticationEntryPoint, $errorPage, $accessDeniedHandler, $logger);
    }

    protected function setTargetPath(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return;
        }

        if ($request->hasSession() && ($request->isMethodSafe() || $request->get('_route') == 'engishop_front_cart_add')) {
            $request->getSession()->set('_security.'.$this->providerKey.'.target_path', $request->getUri());
        }
    }
}{

}