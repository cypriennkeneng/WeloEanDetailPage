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
        $eanActive = (bool)$this->configuration->getActive('EAN');
        $manufacturerActive = (bool)$this->configuration->getActive('ManufacturerNumber');
        $weightActive = (bool)$this->configuration->getActive('Weight');
        $lengthActive = (bool)$this->configuration->getActive('Length');
        $heightActive = (bool)$this->configuration->getActive('Height');
        $widthActive = (bool)$this->configuration->getActive('Width');

        $eanPosition = (int)$this->configuration->getPosition('EAN');
        $manufacturerPosition = (int)$this->configuration->getPosition('ManufacturerNumber');
        $weightPosition = (int)$this->configuration->getPosition('Weight');
        $lengthPosition = (int)$this->configuration->getLengthPosition('WWeloEanDetailPageLengthDetailPosition');
        $heightPosition = (int)$this->configuration->getPosition('Height');
        $widthPosition = (int)$this->configuration->getPosition('Width');


        /** @var SalesChannelProductEntity $product */
        $product = $event->getPage()->getProduct();

        $data = [];

        if ($eanActive && $product->getEan()) {
            $data[] = [
                'label' => 'EAN',
                'position' => $eanPosition,
                'content' => $product->getEan(),
                'itemprop' => 'ean',
            ];
        }

        if ($manufacturerActive && $product->getManufacturerNumber()) {
            $data[] = [
                'label' => 'Manufacturer Nr',
                'position' => $manufacturerPosition,
                'content' => $product->getManufacturerNumber(),
                'itemprop' => 'manufacturer number',
            ];
        }

        if ($weightActive && $product->getWeight()) {
            $data[] = [
                'label' => 'Weight',
                'position' => $weightPosition,
                'content' => $product->getWeight() . ' kg',
                'itemprop' => 'weight',
            ];
        }


        if ($lengthActive && $product->getLength()) {
            $data[] = [
                'label' => 'Length',
                'position' => $lengthPosition,
                'content' => $product->getLength() . ' mm',
                'itemprop' => 'length',
            ];
        }

        if ($heightActive && $product->getHeight()) {
            $data[] = [
                'label' => 'Height',
                'position' => $heightPosition,
                'content' => $product->getHeight() . ' mm',
                'itemprop' => 'height',
            ];
        }

        if ($widthActive && $product->getWidth()) {
            $data[] = [
                'label' => 'Width',
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

    /**
     * Helper method for debugging
     * @param $data
     */
    function dumb($data){
        highlight_string("<?php\n " . var_export($data, true) . "?>");
        echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
        die();
    }
}
