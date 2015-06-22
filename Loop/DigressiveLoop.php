<?php

namespace DigressivePrice\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use DigressivePrice\Model\DigressivePriceQuery;
use Thelia\Model\AttributeCombinationQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;

/**
 * Class DigressiveLoop
 * Definition of the Digressive loop of DigressivePrice module
 *
 * @package DigressivePrice\Loop
 * @author Etienne PERRIERE <eperriere@openstudio.fr> - Nexxpix - OpenStudio
 */
class DigressiveLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    public $countable = true;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('product_id'),
            Argument::createIntTypeArgument('product_sale_elements_id')
        );
    }

    public function buildModelCriteria()
    {
        $productId = $this->getProductId();
        $productSaleElementsId = $this->getProductSaleElementsId();
        $search = DigressivePriceQuery::create();

        if (!is_null($productId)) {
            $search->filterByProductId($productId);
        }

        if (!is_null($productSaleElementsId)) {
            $search->filterByProductSaleElementsId($productSaleElementsId);
        }

        return $search;
    }

    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $digressivePrice) {
            $loopResultRow = new LoopResultRow($digressivePrice);

            // Get product
            $productId = $digressivePrice->getProductId();
            $product = ProductQuery::create()->findOneById($productId);

            $pse = ProductSaleElementsQuery::create()->findOneById($digressivePrice->getProductSaleElementsId());
            $pseAttr = AttributeCombinationQuery::create()->findOneByProductSaleElementsId($digressivePrice->getProductSaleElementsId());

            // Get prices
            $price = $digressivePrice->getPrice();
            $promo = $digressivePrice->getPromoPrice();

            // Get country
            $taxCountry = $this->container->get('thelia.taxEngine')->getDeliveryCountry();

            // Get taxed prices
            $taxedPrice = $product->getTaxedPrice($taxCountry, $price);
            $taxedPromoPrice = $product->getTaxedPromoPrice($taxCountry, $promo);

            $loopResultRow
                    ->set("ID", $digressivePrice->getId())
                    ->set("PRODUCT_ID", $productId)
                    ->set("PRODUCT_TITLE", $product->getTitle())
                    ->set("PRODUCT_SALE_ELEMENTS_ID", $digressivePrice->getProductSaleElementsId())
                    ->set("QUANTITY_FROM", $digressivePrice->getQuantityFrom())
                    ->set("QUANTITY_TO", $digressivePrice->getQuantityTo())
                    ->set("PRICE", $price)
                    ->set("PROMO_PRICE", $promo)
                    ->set("TAXED_PRICE", $taxedPrice)
                    ->set("TAXED_PROMO_PRICE", $taxedPromoPrice);

            if($pseAttr){
                $loopResultRow->set("PRODUCT_SALE_ELEMENTS_TITLE", $pseAttr->getVirtualColumn("attribute_av_i18n_TITLE"));
            }

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
