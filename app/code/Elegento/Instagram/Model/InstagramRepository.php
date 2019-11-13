<?php

namespace Elegento\Instagram\Model;

use Elegento\Instagram\Api\InstagramRepositoryInterface;
use Elegento\Instagram\Api\Data\InstagramSearchResultsInterfaceFactory;
use Elegento\Instagram\Api\Data\InstagramInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Elegento\Instagram\Model\ResourceModel\Instagram as ResourceInstagram;
use Elegento\Instagram\Model\ResourceModel\Instagram\CollectionFactory as InstagramCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

class InstagramRepository implements InstagramRepositoryInterface
{

    protected $resource;

    protected $instagramFactory;

    protected $instagramCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataInstagramFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceInstagram $resource
     * @param InstagramFactory $instagramFactory
     * @param InstagramInterfaceFactory $dataInstagramFactory
     * @param InstagramCollectionFactory $instagramCollectionFactory
     * @param InstagramSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceInstagram $resource,
        InstagramFactory $instagramFactory,
        InstagramInterfaceFactory $dataInstagramFactory,
        InstagramCollectionFactory $instagramCollectionFactory,
        InstagramSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->instagramFactory = $instagramFactory;
        $this->instagramCollectionFactory = $instagramCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataInstagramFactory = $dataInstagramFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Elegento\Instagram\Api\Data\InstagramInterface $instagram
    ) {
        /* if (empty($instagram->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $instagram->setStoreId($storeId);
        } */

        $instagramData = $this->extensibleDataObjectConverter->toNestedArray(
            $instagram,
            [],
            \Elegento\Instagram\Api\Data\InstagramInterface::class
        );

        $instagramModel = $this->instagramFactory->create()->setData($instagramData);

        try {
            $this->resource->save($instagramModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the instagram: %1',
                $exception->getMessage()
            ));
        }
        return $instagramModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($instagramId)
    {
        $instagram = $this->instagramFactory->create();
        $this->resource->load($instagram, $instagramId);
        if (!$instagram->getId()) {
            throw new NoSuchEntityException(__('Instagram with id "%1" does not exist.', $instagramId));
        }
        return $instagram->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->instagramCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Elegento\Instagram\Api\Data\InstagramInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Elegento\Instagram\Api\Data\InstagramInterface $instagram
    ) {
        try {
            $instagramModel = $this->instagramFactory->create();
            $this->resource->load($instagramModel, $instagram->getInstagramId());
            $this->resource->delete($instagramModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Instagram: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($instagramId)
    {
        return $this->delete($this->get($instagramId));
    }
}