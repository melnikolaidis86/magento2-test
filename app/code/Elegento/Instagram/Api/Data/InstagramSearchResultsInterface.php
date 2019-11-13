<?php

namespace Elegento\Instagram\Api\Data;

interface InstagramSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Instagram list.
     * @return \Elegento\Instagram\Api\Data\InstagramInterface[]
     */
    public function getItems();

    /**
     * Set image_url list.
     * @param \Elegento\Instagram\Api\Data\InstagramInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}