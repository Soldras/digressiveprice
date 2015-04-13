<?php

namespace DigressivePrice\Event;

use Thelia\Core\Event\ActionEvent;

/**
 * Class DigressivePriceEvent
 * @package DigressivePrice\Event
 * @author Etienne PERRIERE <eperriere@openstudio.fr> - Nexxpix - OpenStudio
 */
class DigressivePriceEvent extends ActionEvent {

    protected $productId;
    protected $price;
    protected $promoPrice;
    protected $quantityFrom;
    protected $quantityTo;

    function __construct(
        $productId,
        $price,
        $promoPrice,
        $quantityFrom,
        $quantityTo
    ) {
        $this->productId = $productId;
        $this->price = $price;
        $this->promoPrice = $promoPrice;
        $this->quantityFrom = $quantityFrom;
        $this->quantityTo = $quantityTo;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }

    /**
     * @param mixed $promoPrice
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;
    }

    /**
     * @return mixed
     */
    public function getQuantityFrom()
    {
        return $this->quantityFrom;
    }

    /**
     * @param mixed $quantityFrom
     */
    public function setQuantityFrom($quantityFrom)
    {
        $this->quantityFrom = $quantityFrom;
    }

    /**
     * @return mixed
     */
    public function getQuantityTo()
    {
        return $this->quantityTo;
    }

    /**
     * @param mixed $quantityTo
     */
    public function setQuantityTo($quantityTo)
    {
        $this->quantityTo = $quantityTo;
    }


}