<?php
namespace Welo\EanDetailPage\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * Class Config
 *
 * @author Steven Thorne <shopware@webloupe.de>
 * @copyright Copyright (c) 2017-2019 Web Loupe
 * @package EanDetailPage\Services
 * @version   1
 */
class Configuration
{
    /**
     * @var \Shopware\Core\System\SystemConfig\SystemConfigService
     */
    private $systemConfigService;
    
    public const WELO_CONFIG_DOMAIN = 'WeloEanDetailPage.config.';
    
    /**
     * Configuration constructor.
     *
     * @param \Shopware\Core\System\SystemConfig\SystemConfigService $systemConfigService
     */
    public function __construct(SystemConfigService $systemConfigService) {
        $this->systemConfigService = $systemConfigService;
    }
    
    /**
     * @param $key
     * @return bool|mixed
     * @throws \Exception
     */
    public function getPluginConfig($key)
    {
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key);
    }

    /**
     * @param $key
     * @return bool|mixed
     * @throws \Exception
     */
    public function getActive($key)
    {
        $key = 'WeloEanDetailPage' . $key . 'DetailActive';
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key);
    }

    /**
     * @param $key
     * @return int
     * @throws \Exception
     */
    public function getPosition($key)
    {
        $key = 'WeloEanDetailPage' . $key . 'DetailPosition';
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key);
    }
}
