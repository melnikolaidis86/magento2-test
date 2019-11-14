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
    protected $instagramCollectionFactory;
    protected $dateTime;

    /**
     * Instagram constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Elegento\Instagram\Api\Data\InstagramInterfaceFactory $instagramFactory
     * @param \Elegento\Instagram\Api\InstagramRepositoryInterface $instagramRepository
     * @param \Elegento\Instagram\Model\ResourceModel\Instagram\CollectionFactory $instagramCollectionFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Elegento\Instagram\Api\Data\InstagramInterfaceFactory $instagramFactory,
        \Elegento\Instagram\Api\InstagramRepositoryInterface $instagramRepository,
        \Elegento\Instagram\Model\ResourceModel\Instagram\CollectionFactory $instagramCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ){
        parent::__construct($context);
        $this->curl = $curl;
        $this->jsonHelper = $jsonHelper;
        $this->instagramFactory = $instagramFactory;
        $this->instagramRepository = $instagramRepository;
        $this->instagramCollectionFactory = $instagramCollectionFactory;
        $this->dateTime = $dateTime;
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
        $instagramData = $this->getLatestMedia(); //Fetch fresh data from instagram
        $postIds = array();

        /** @var \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $instagramCollection */
        $instagramCollection = $this->instagramCollectionFactory->create();

        foreach ($instagramCollection as $data) {
            $postIds[] = $data->getPostId(); //Retrieve already saved post ids
        }

        foreach ($instagramData as $post) {

            if(in_array($post['id'], $postIds)) {
                continue; //If already in database continue
            }

            /** @var \Elegento\Instagram\Api\Data\InstagramInterface $instagramItem */
            $instagramItem = $this->instagramFactory->create();

            $imageUrl = $instagramItem->saveImageLocal($post['images']['low_resolution']['url']); //save image to local folder

            $instagramItem->setPostId($post['id']);
            $instagramItem->setImageUrl($post['images']['low_resolution']['url']);
            $instagramItem->setUploadedImageUrl($imageUrl);
            $instagramItem->setLikes($post['likes']['count']);
            $instagramItem->setTags(implode(',', $post['tags']));
            $instagramItem->setPostLink($post['link']);
            $instagramItem->setCaption($post['caption']['text']);
            $instagramItem->setCreatedAt($this->dateTime->date(null, $post['created_time']));

            $this->instagramRepository->save($instagramItem);
        }
    }

    /**
     * Remove uploaded images for unused posts
     *
     */
    public function removeUnusedImages()
    {
        /** @var \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $instagramCollection */
        $instagramCollection = $this->instagramCollectionFactory->create();

        $instagramCollection->setPageSize(self::IMAGE_COUNT) // only get images that is going to be displayed
            ->setCurPage(1);

        $postIds = array(); //Store in array all images that is going to be displayed
        foreach ($instagramCollection as $item) {
            $postIds[] = $item->getPostId();
        }

        /** @var \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $instagramCollection */
        $instagramCollection = $this->instagramCollectionFactory->create(); //create new collection with all images

        foreach ($instagramCollection as $item) {

            if(in_array($item->getPostId(), $postIds)) {
                continue;
            }

            /** @var \Elegento\Instagram\Api\Data\InstagramInterface $instagramItem */
            $instagramItem = $this->instagramFactory->create();

            try {

                //Remove local image set null to table
                if($instagramItem->removeImageLocal($item->getUploadedImageUrl())) {
                    $item->setUploadedImageUrl(null);
                    $item->save();
                }
            } catch (\Magento\Framework\Exception\FileSystemException $exception) {
                $exception->getMessage();
            }
        }
    }
}