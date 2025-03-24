<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Cookie;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Framework\Cookie\CookieProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomCookieProvider implements CookieProviderInterface
{
    public const WBM_GTM_ENABLED_COOKIE_NAME = 'wbm-tagmanager-enabled';

    private const WBM_GTM_ENABLED_COOKIE_DATA = [
        'snippet_name' => 'wbmTagManager.cookie.groupStatisticalTagmanager',
        'cookie' => self::WBM_GTM_ENABLED_COOKIE_NAME,
        'value' => '1',
        'expiration' => '90',
    ];

    private const WBM_GTM_COOKIE_GROUP_DATA = [
        'snippet_name' => 'wbmTagManager.cookie.groupStatistical',
        'snippet_description' => 'wbmTagManager.cookie.groupStatisticalDescription',
        'entries' => [
            self::WBM_GTM_ENABLED_COOKIE_DATA,
        ],
    ];

    /**
     * @var CookieProviderInterface
     */
    private $originalService;

    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        CookieProviderInterface $service,
        SystemConfigService $systemConfigService,
        RequestStack $requestStack
    ) {
        $this->originalService = $service;
        $this->systemConfigService = $systemConfigService;
        $this->requestStack = $requestStack;
    }

    public function getCookieGroups(): array
    {
        $salesChannelId = $this->requestStack->getCurrentRequest()->attributes->get('sw-sales-channel-id');
        $config = $this->systemConfigService->get('WbmTagManagerAnalytics.config', $salesChannelId);

        if (
            (isset($config['isInactive']) && $config['isInactive'] === true)
            || (!isset($config['hasSWConsentSupport']) || $config['hasSWConsentSupport'] === false)
            || (!isset($config['containerId']) || empty(trim($config['containerId'])))
        ) {
            return $this->originalService->getCookieGroups();
        }

        return $this->addEntryToStatisticalGroup();
    }

    protected function addEntryToStatisticalGroup(): array
    {
        $cookieGroups = $this->originalService->getCookieGroups();

        foreach ($cookieGroups as &$group) {
            if ($group['snippet_name'] !== 'cookie.groupStatistical') {
                continue;
            }

            $group['entries'] = array_merge($group['entries'], [self::WBM_GTM_ENABLED_COOKIE_DATA]);

            return $cookieGroups;
        }

        return array_merge($cookieGroups, [self::WBM_GTM_COOKIE_GROUP_DATA]);
    }
}
