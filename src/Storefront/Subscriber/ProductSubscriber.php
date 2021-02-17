<?php declare(strict_types=1);

namespace Welo\EanDetailPage\Storefront\Subscriber;

use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Welo\EanDetailPage\Service\Configuration;

class ProductSubscriber implements EventSubscriberInterface
{
    /**
     * @var Configuration
     */
    private $configuration;
    
    /**
     * ProductSubscriber constructor.
     *
     * @param Configuration $configuration
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
     * @param ProductPageLoadedEvent $event
     * @throws \Exception
     */
    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        $saleChannelId = $event->getSalesChannelContext()->getSalesChannel()->getId();

        $eanActive = (bool)$this->configuration->getActive('EAN', $saleChannelId);
        $manufacturerActive = (bool)$this->configuration->getActive('ManufacturerNumber',$saleChannelId);
        $manufacturerNameActive = (bool)$this->configuration->getActive('ManufacturerName', $saleChannelId);
        $weightActive = (bool)$this->configuration->getActive('Weight', $saleChannelId);
        $lengthActive = (bool)$this->configuration->getActive('Length', $saleChannelId);
        $heightActive = (bool)$this->configuration->getActive('Height', $saleChannelId);
        $widthActive = (bool)$this->configuration->getActive('Width', $saleChannelId);

        $eanPosition = (int)$this->configuration->getPosition('EAN', $saleChannelId);
        $manufacturerPosition = (int)$this->configuration->getPosition('ManufacturerNumber', $saleChannelId);
        $manufacturerNamePosition = (int)$this->configuration->getPosition('ManufacturerName', $saleChannelId);
        $weightPosition = (int)$this->configuration->getPosition('Weight', $saleChannelId);
        $lengthPosition = (int)$this->configuration->getPluginConfig('WWeloEanDetailPageLengthDetailPosition', $saleChannelId);

        $heightPosition = (int)$this->configuration->getPosition('Height', $saleChannelId);
        $widthPosition = (int)$this->configuration->getPosition('Width', $saleChannelId);

        /** @var SalesChannelProductEntity $product */
        $product = $event->getPage()->getProduct();

        $data = [];

        if ($eanActive && $product->getEan()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.ean'),
                'position' => $eanPosition,
                'content' => $product->getEan(),
                'itemprop' => 'ean',
            ];
        }

        if ($manufacturerActive && $product->getManufacturerNumber()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.manufacturerNumber'),
                'position' => $manufacturerPosition,
                'content' => $product->getManufacturerNumber(),
                'itemprop' => 'manufacturer number',
            ];
        }

        if ($manufacturerNameActive && $product->getManufacturer()->getName()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.manufacturerName'),
                'position' => $manufacturerNamePosition,
                'content' => $product->getManufacturer()->getName(),
                'itemprop' => 'manufacturer',
            ];
        }

        if ($weightActive && $product->getWeight()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.weight'),
                'position' => $weightPosition,
                'content' => $product->getWeight() . ' kg',
                'itemprop' => 'weight',
            ];
        }


        if ($lengthActive && $product->getLength()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.length'),
                'position' => $lengthPosition,
                'content' => $product->getLength() . ' mm',
                'itemprop' => 'length',
            ];
        }

        if ($heightActive && $product->getHeight()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.height'),
                'position' => $heightPosition,
                'content' => $product->getHeight() . ' mm',
                'itemprop' => 'height',
            ];
        }

        if ($widthActive && $product->getWidth()) {
            $data[] = [
                'label' => $this->configuration->translate('welo-ean-detail-page.detail.width'),
                'position' => $widthPosition,
                'content' => $product->getWidth() . ' mm',
                'itemprop' => 'width',
            ];
        }

        usort($data, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $event->getPage()->getProduct()->assign(
            [
                'WeloEanDetailData' => $data,
            ]
        );
    }
}
