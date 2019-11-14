<?php

namespace Elegento\Instagram\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface InstagramInterface extends ExtensibleDataInterface
{
    const INSTAGRAM_ID = 'instagram_id';
    const POST_ID = 'post_id';
    const IMAGE_URL = 'image_url';
    const UPLOADED_IMAGE_URL = 'uploaded_image_url';
    const POST_LINK = 'post_link';
    const CAPTION = 'caption';
    const TAGS = 'tags';
    const LIKES = 'likes';
    const CREATED_AT = 'created_at';
    const TABLE_NAME = 'elegento_instagram_feed';
    const FOLDER_NAME = 'instagram';

    /**
     * Get instagram_id
     * @return string|null
     */
    public function getInstagramId();

    /**
     * Set instagram_id
     * @param string $instagramId
     * @return \Elegento\Instagram\Api\Data\InstagramInterface
     */
    public function setInstagramId($instagramId);

    /**
     * Get post_id
     * @return string|null
     */
    public function getPostId();

    /**
     * Set post_id
     * @param string $postId
     * @return InstagramInterface
     */
    public function setPostId($postId);

    /**
     * Get image_url
     * @return string|null
     */
    public function getImageUrl();

    /**
     * Set image_url
     * @param string $imageUrl
     * @return InstagramInterface
     */
    public function setImageUrl($imageUrl);

    /**
     * Get uploaded_image_url
     * @return string|null
     */
    public function getUploadedImageUrl();

    /**
     * Set uploaded_image_url
     * @param string $imageUrl
     * @return InstagramInterface
     */
    public function setUploadedImageUrl($imageUrl);

    /**
     * Get post_link
     * @return string|null
     */
    public function getPostLink();

    /**
     * Set post_link
     * @param string $postLink
     * @return InstagramInterface
     */
    public function setPostLink($postLink);


    /**
     * Get caption
     * @return string|null
     */
    public function getCaption();

    /**
     * Set caption
     * @param string $caption
     * @return InstagramInterface
     */
    public function setCaption($caption);

    /**
     * Get tags
     * @return string|null
     */
    public function getTags();

    /**
     * Set tags
     * @param string $tags
     * @return InstagramInterface
     */
    public function setTags($tags);

    /**
     * Get likes
     * @return string|null
     */
    public function getLikes();

    /**
     * Set likes
     * @param string $likes
     * @return InstagramInterface
     */
    public function setLikes($likes);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return InstagramInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Elegento\Instagram\Api\Data\InstagramExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Elegento\Instagram\Api\Data\InstagramExtensionInterface $extensionAttributes
     * @return InstagramInterface
     */
    public function setExtensionAttributes(
        \Elegento\Instagram\Api\Data\InstagramExtensionInterface $extensionAttributes
    );

    /**
     * @param $imageUrl
     * @return bool|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function saveImageLocal($imageUrl);

    /**
     * @param $imageUrl
     * @return bool
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function removeImageLocal($imageUrl);
}