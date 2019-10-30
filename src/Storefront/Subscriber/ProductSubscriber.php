<?php declare(strict_types=1);

namespace Welo\EanDetailPage\Storefront\Subscriber;

use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Welo\EanDetailPage\Service\Configuration;

class ProductSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Welo\EanDetailPage\Service\Configuration
     */
    private $configuration;
    
    /**
     * ProductSubscriber constructor.
     *
     * @param \Welo\EanDetailPage\Service\Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPageLoaded'
        ];
    }
    
    /**
     * @param \Shopware\Storefront\Page\Product\ProductPageLoadedEvent $event
     * @throws \Exception
     */
    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $eanActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageEANDetailActive');
        $manufacturerActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageManufacturerNumberDetailActive');
        $weightActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageWeightDetailActive');
        $lengthActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageLengthDetailActive');
        $heightActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageHeightDetailActive');
        $widthActive = (bool)$this->configuration->getPluginConfig('WeloEanDetailPageWidthDetailActive');
        
        $event->getPage()->getProduct()->assign(
            [
                'WeloEanDetailPageEANDetailActive' => $eanActive,
                'WeloEanDetailPageManufacturerNumberDetailActive' => $manufacturerActive,
                'WeloEanDetailPageWeightDetailActive' => $weightActive,
                'WeloEanDetailPageLengthDetailActive' => $lengthActive,
                'WeloEanDetailPageHeightDetailActive' => $heightActive,
                'WeloEanDetailPageWidthDetailActive' => $widthActive,
            ]
        );
    }
}
