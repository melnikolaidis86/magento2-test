<?php

namespace Elegento\Instagram\Model\Data;

use Elegento\Instagram\Api\Data\InstagramInterface;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;

class Instagram extends \Magento\Framework\Api\AbstractExtensibleObject implements InstagramInterface
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $file;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;


    /**
     * Instagram constructor.
     * @param ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $attributeValueFactory
     * @param DirectoryList $directoryList
     * @param \Magento\Framework\Filesystem\Io\File $file
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $attributeValueFactory,
        DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ){
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->storeManager = $storeManager;
    }

    /**
     * Get instagram_id
     * @return string|null
     */
    public function getInstagramId()
    {
        return $this->_get(self::INSTAGRAM_ID);
    }

    /**
     * Set instagram_id
     * @param string $instagramId
     * @return \Elegento\Instagram\Api\Data\InstagramInterface
     */
    public function setInstagramId($instagramId)
    {
        return $this->setData(self::INSTAGRAM_ID, $instagramId);
    }

    /**
     * Get post_id
     * @return string|null
     */
    public function getPostId()
    {
        return $this->_get(self::POST_ID);
    }

    /**
     * Set post_id
     * @param string $postId
     * @return InstagramInterface
     */
    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    /**
     * Get image_url
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->_get(self::IMAGE_URL);
    }

    /**
     * Set image_url
     * @param string $imageUrl
     * @return \Elegento\Instagram\Api\Data\InstagramInterface
     */
    public function setImageUrl($imageUrl)
    {
        return $this->setData(self::IMAGE_URL, $imageUrl);
    }

    /**
     * Get post_link
     * @return string|null
     */
    public function getPostLink()
    {
        return $this->_get(self::POST_LINK);
    }

    /**
     * Set post_link
     * @param string $postLink
     * @return InstagramInterface
     */
    public function setPostLink($postLink)
    {
        return $this->setData(self::POST_LINK, $postLink);
    }

    /**
     * Get caption
     * @return string|null
     */
    public function getCaption()
    {
        return $this->_get(self::CAPTION);
    }

    /**
     * Set caption
     * @param string $caption
     * @return InstagramInterface
     */
    public function setCaption($caption)
    {
        return $this->setData(self::CAPTION, $caption);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Elegento\Instagram\Api\Data\InstagramExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Elegento\Instagram\Api\Data\InstagramExtensionInterface $extensionAttributes
     * @return InstagramInterface
     */
    public function setExtensionAttributes(
        \Elegento\Instagram\Api\Data\InstagramExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @param $imageUrl
     * @return string|bool
     */
    public function saveImageLocal($imageUrl)
    {
        $dir = $this->getMediaDir();
        $this->file->checkAndCreateFolder($dir);
        $imageName = explode('?', baseName($imageUrl));
        $newFileName = $dir . DIRECTORY_SEPARATOR . $imageName[0];

        /** read file from URL and copy it to the new destination */
        $result = $this->file->read($imageUrl, $newFileName);
        if($result) {
            return $this->storeManager->getStore()->getUrl('pub/media') . self::FOLDER_NAME . DIRECTORY_SEPARATOR . $imageName[0];
        }

        return false;
    }

    /**
     * Media directory name for the temporary file storage
     * pub/media/instagram
     *
     * @return string
     */
    private function getMediaDir()
    {
        return $this->directoryList->getPath(DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . self::FOLDER_NAME;
    }
}