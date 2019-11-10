<?php

namespace Elegento\Instagram\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const SLICK_DOTS = 0;
    const SLICK_ARROWS = 1;


    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ){
        parent::__construct($context);
    }

    public function slickDots()
    {
        return self::SLICK_DOTS;
    }

    public function slickArrows()
    {
        return self::SLICK_ARROWS;
    }
}