<?php

namespace Elegento\Instagram\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface InstagramInterface extends ExtensibleDataInterface
{
    const POST_ID = 'post_id';
    const IMAGE_URL = 'image_url';
    const POST_LINK = 'post_link';
    const CAPTION = 'caption';
    const TABLE_NAME = 'elegento_instagram_feed';

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
}