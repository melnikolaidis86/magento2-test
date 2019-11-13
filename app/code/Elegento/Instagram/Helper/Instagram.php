<?php

namespace Elegento\Instagram\Helper;


class Instagram extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ACCESS_TOKEN = '1162125356.5655338.01348c85eab447f6af3070b8c225b900';
    const IMAGE_COUNT = '8';

    protected $curl;
    protected $jsonHelper;
    protected $instagramFactory;
    protected $instagramRepository;

    /**
     * Instagram constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Elegento\Instagram\Api\Data\InstagramInterfaceFactory $instagramFactory
     * @param \Elegento\Instagram\Api\InstagramRepositoryInterface $instagramRepository
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Elegento\Instagram\Api\Data\InstagramInterfaceFactory $instagramFactory,
        \Elegento\Instagram\Api\InstagramRepositoryInterface $instagramRepository
    ){
        parent::__construct($context);
        $this->curl = $curl;
        $this->jsonHelper = $jsonHelper;
        $this->instagramFactory = $instagramFactory;
        $this->instagramRepository = $instagramRepository;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        $url = 'https://api.instagram.com/v1/users/self/?access_token=' . self::ACCESS_TOKEN;
        $this->curl->get($url);
        $data = $this->curl->getBody();
        $response = $this->jsonHelper->jsonDecode($data);

        return $response['data']['username'];
    }

    /**
     * @return array
     */
    public function getLatestMedia()
    {
        $url = 'https://api.instagram.com/v1/users/self/media/recent/?count=' . self::IMAGE_COUNT . '&access_token=' . self::ACCESS_TOKEN;
        $this->curl->get($url);
        $data = $this->curl->getBody();
        $response = $this->jsonHelper->jsonDecode($data);

        return $response['data'];
    }

    /**
     * Save Instagram data to database
     *
     */
    public function updateFeed()
    {
        $instagramData = $this->getLatestMedia();
        foreach ($instagramData as $post) {

            /** @var \Elegento\Instagram\Api\Data\InstagramInterface $instagramItem */
            $instagramItem = $this->instagramFactory->create();

            $instagramItem->setPostId($post['id']);
            $instagramItem->setImageUrl($post['images']['low_resolution']['url']);
            $instagramItem->setPostLink($post['link']);
            $instagramItem->setCaption($post['caption']['text']);

            $this->instagramRepository->save($instagramItem);
        }
    }
}