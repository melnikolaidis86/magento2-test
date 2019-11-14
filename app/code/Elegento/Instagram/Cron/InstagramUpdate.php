<?php
namespace Elegento\Instagram\Cron;

class InstagramUpdate
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Elegento\Instagram\Helper\Instagram
     */
    protected $instagramHelper;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Elegento\Instagram\Helper\Instagram $instagramHelper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Elegento\Instagram\Helper\Instagram $instagramHelper
    ){
        $this->logger = $logger;
        $this->instagramHelper = $instagramHelper;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob InstagramUpdate is executed.");

        $this->instagramHelper->updateFeed(); //Update Feed

        $this->instagramHelper->removeUnusedImages(); //Remove local image url for unused images

        $this->logger->addInfo("Cronjob InstagramUpdate has been completed.");

    }
}