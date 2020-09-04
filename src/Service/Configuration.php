<?php
namespace Welo\EanDetailPage\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Configuration constructor.
     *
     * @param \Shopware\Core\System\SystemConfig\SystemConfigService $systemConfigService
     * @param TranslatorInterface $translator
     */
    public function __construct(SystemConfigService $systemConfigService, TranslatorInterface $translator) {
        $this->systemConfigService = $systemConfigService;
        $this->translator = $translator;
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
        //die('hh '.$key);
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key);
    }

    /**
     * @param $key
     * @return int
     * @throws \Exception
     */
    public function getLengthPosition($key)
    {
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key);
    }

    public function translate($name) {
        return $this->translator->trans($name);
    }
}
