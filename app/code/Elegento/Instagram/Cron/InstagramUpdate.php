<?php
namespace Elegento\Instagram\Cron;

class InstagramUpdate
{

    protected $logger;
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
        //$this->logger->addInfo("Cronjob InstagramUpdate is executed.");

        //var_dump($this->instagramHelper->getLatestMedia());

        $this->instagramHelper->updateFeed();

    }
}