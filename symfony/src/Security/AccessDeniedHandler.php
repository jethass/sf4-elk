<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    protected $session;
    protected $router;
    protected $request;
    public function __construct(RouterInterface $router)
    {
        $this->session = new Session();
        $this->router = $router;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        //$content = "accès non autorisé";
        $this->session->getFlashBag()->add('alert', 'acèes non autorisé.');
        $route = $this->router->generate('admin_login');
        return new Response(new RedirectResponse($route));
    }
}