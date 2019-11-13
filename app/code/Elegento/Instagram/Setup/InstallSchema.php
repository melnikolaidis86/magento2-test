<?php

namespace Elegento\Instagram\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Elegento\Instagram\Api\Data\InstagramInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->createInstagramTable($installer);

        $installer->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    protected function createInstagramTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(InstagramInterface::TABLE_NAME)
        )->addColumn(
            InstagramInterface::INSTAGRAM_ID,
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Page ID'
        )->addColumn(
            InstagramInterface::POST_ID,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'POST ID'
        )->addColumn(
            InstagramInterface::IMAGE_URL,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'INSTAGRAM URL'
        )->addColumn(
            InstagramInterface::POST_LINK,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'POST LINK'
        )->addColumn(
            InstagramInterface::CAPTION,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'CAPTION'
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable(InstagramInterface::TABLE_NAME),
                [InstagramInterface::IMAGE_URL, InstagramInterface::POST_LINK],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            [InstagramInterface::IMAGE_URL, InstagramInterface::POST_LINK],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Instagram Data Feed table'
        );

        $setup->getConnection()->createTable($table);
    }
}