<?php

namespace Elegento\Instagram\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Instagram extends Template implements BlockInterface
{
    protected $_template = "widget/instagram.phtml";
    protected $_instagramData;

    /**
     * @var \Elegento\Instagram\Helper\Instagram
     */
    protected $instagramHelper;

    /**
     * Instagram constructor.
     * @param Template\Context $context
     * @param \Elegento\Instagram\Helper\Instagram $instagramHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Elegento\Instagram\Helper\Instagram $instagramHelper,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->instagramHelper = $instagramHelper;
        $this->_instagramData =  $this->instagramHelper->getLatestMedia();
    }

    /**
     * @return array
     */
    public function getInstagramData()
    {
        $data = array();
        foreach ($this->_instagramData as $post) {
            $data[$post['id']]['image_src'] = $post['images']['low_resolution']['url'];
            $data[$post['id']]['link'] = $post['link'];
            $data[$post['id']]['caption'] = $post['caption']['text'];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->instagramHelper->getAccountName();
    }
}