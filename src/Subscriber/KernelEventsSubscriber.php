<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Subscriber;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\KernelListenerPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\SessionHandlerFactory;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Wbm\TagManagerAnalytics\Services\DataLayerModulesInterface;
use Wbm\TagManagerAnalytics\Services\DataLayerRendererInterface;
use Wbm\TagManagerAnalytics\Utility\SessionUtility;

class KernelEventsSubscriber implements EventSubscriberInterface
{
    /**
     * @var DataLayerModulesInterface
     */
    private $modules;

    /**
     * @var DataLayerRendererInterface
     */
    private $dataLayerRenderer;

    public function __construct(
        DataLayerModulesInterface $modules,
        DataLayerRendererInterface $dataLayerRender
    ) {
        $this->modules = $modules;
        $this->dataLayerRenderer = $dataLayerRender;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['getDataLayerForXmlHttpRequest', KernelListenerPriorities::KERNEL_CONTROLLER_EVENT_SCOPE_VALIDATE_POST],
            ],
            KernelEvents::RESPONSE => [
                ['prependDataLayerToResponse', -1],
            ],
        ];
    }

    public function getDataLayerForXmlHttpRequest(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        if (!$this->isStorefrontRequest($request)) {
            return;
        }

        $modules = $this->modules->getModules();
        $route = $request->attributes->get('_route');
        $session = $request->getSession();

        if (!array_key_exists($route, $modules)
            || empty($modules[$route])
            || $session->has(SessionUtility::ATTRIBUTE_NAME)
        ) {
            return;
        }

        $salesChannelId = $request->get('sw-sales-channel-id');
        $isActive = !empty($this->modules->getContainerId($salesChannelId)) && $this->modules->isActive($salesChannelId);

        if (!$isActive) {
            return;
        }

        $this->dataLayerRenderer->setVariables($route, [])->renderDataLayer($route);
    }

    public function prependDataLayerToResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        if (!$this->isStorefrontRequest($request)) {
            return;
        }

        $route = $request->attributes->get('_route');
        $dataLayer = $this->dataLayerRenderer->getDataLayer($route);
        $session = $request->getSession();
        if ($dataLayer !== null) {
            $dataLayer = SessionUtility::injectSessionVars($dataLayer, $session);
            $dataLayer = json_encode($dataLayer);
        }

        if (!empty($dataLayer) && $response->isRedirect()) {
            $session->set(SessionUtility::ATTRIBUTE_NAME, $dataLayer);

            return;
        }

        if (!$request->isXmlHttpRequest()) {
            return;
        }

        $storedDatalayer = $session->get(SessionUtility::ATTRIBUTE_NAME);
        $session->remove(SessionUtility::ATTRIBUTE_NAME);
        if ($storedDatalayer && in_array($route, $this->modules->getResponseRoutes(), true)) {
            $dataLayer = $storedDatalayer;
        }

        if (empty($dataLayer)) {
            return;
        }

        $dataLayerScriptTag = sprintf(
            '<script id="wbm-data-layer">%s</script>',
            $dataLayer
        );

        $content = $dataLayerScriptTag . PHP_EOL . $response->getContent();
        $response->setContent($content);

        $event->setResponse($response);
    }

    private function isStorefrontRequest(Request $request)
    {
        if ($request->attributes->has('sw-context')
            && $request->attributes->get('sw-context') instanceof Context
            && $request->attributes->get('sw-context')->getScope() === 'user'
        ) {
            return true;
        }

        return false;
    }
}
