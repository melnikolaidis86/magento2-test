<?php


namespace Elegento\Instagram\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface InstagramRepositoryInterface
{

    /**
     * Save Instagram
     * @param \Elegento\Instagram\Api\Data\InstagramInterface $instagram
     * @return \Elegento\Instagram\Api\Data\InstagramInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Elegento\Instagram\Api\Data\InstagramInterface $instagram
    );

    /**
     * Retrieve Instagram
     * @param string $instagramId
     * @return \Elegento\Instagram\Api\Data\InstagramInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($instagramId);

    /**
     * Retrieve Instagram matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Elegento\Instagram\Api\Data\InstagramSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Instagram
     * @param \Elegento\Instagram\Api\Data\InstagramInterface $instagram
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Elegento\Instagram\Api\Data\InstagramInterface $instagram
    );

    /**
     * Delete Instagram by ID
     * @param string $instagramId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($instagramId);
}