<?php
namespace Welo\EanDetailPage\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Configuration
 *
 * @author    Cyprien Nkeneng <cyprien.nkeneng@webloupe.de> - www.webloupe.de
 * @copyright Copyright (c) 2017-2020 WEB LOUPE
 * @package   Welo\EanDetailPage\Service
 * @link      https://www.webloupe.de
 * @version   1
 */
class Configuration
{
    /**
     * @var SystemConfigService
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
     * @param SystemConfigService $systemConfigService
     * @param TranslatorInterface $translator
     */
    public function __construct(SystemConfigService $systemConfigService, TranslatorInterface $translator) {
        $this->systemConfigService = $systemConfigService;
        $this->translator = $translator;
    }

    public function get($saleChannelId)
    {
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN, $saleChannelId);
    }

    /**
     * @param      $key
     * @param null $saleChannelId
     * @return bool|mixed
     */
    public function getPluginConfig($key, $saleChannelId = null)
    {
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key, $saleChannelId);
    }

    /**
     * @param $key
     * @param $saleChannelId
     * @return bool|mixed
     */
    public function getActive($key, $saleChannelId = null)
    {
        $key = 'WeloEanDetailPage' . $key . 'DetailActive';
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key, $saleChannelId);
    }

    /**
     * @param $key
     * @param $saleChannelId
     * @return int
     */
    public function getPosition($key, $saleChannelId = null)
    {
        $key = 'WeloEanDetailPage' . $key . 'DetailPosition';
        return $this->systemConfigService->get(self::WELO_CONFIG_DOMAIN . $key, $saleChannelId);
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
