<?php

namespace Elegento\Instagram\Model\Data;

use Elegento\Instagram\Api\Data\InstagramInterface;

class Instagram extends \Magento\Framework\Api\AbstractExtensibleObject implements InstagramInterface
{

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
}