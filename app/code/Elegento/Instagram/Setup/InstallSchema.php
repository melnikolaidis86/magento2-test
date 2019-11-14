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
     * @throws \Zend_Db_Exception
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
            255,
            ['nullable' => false],
            'POST ID'
        )->addColumn(
            InstagramInterface::IMAGE_URL,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'INSTAGRAM IMAGE URL'
        )->addColumn(
            InstagramInterface::UPLOADED_IMAGE_URL,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => null],
            'UPLOADED IMAGE URL'
        )->addColumn(
            InstagramInterface::POST_LINK,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'POST LINK'
        )->addColumn(
            InstagramInterface::CAPTION,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'CAPTION'
        )->addColumn(
            InstagramInterface::TAGS,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'TAGS'
        )->addColumn(
            InstagramInterface::LIKES,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'TAGS'
        )->addColumn(
            InstagramInterface::CREATED_AT,
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            ['nullable' => false],
            'CREATED AT'
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable(InstagramInterface::TABLE_NAME),
                [InstagramInterface::POST_ID, InstagramInterface::TAGS],
                AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            [InstagramInterface::POST_ID, InstagramInterface::TAGS],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable(InstagramInterface::TABLE_NAME),
                [InstagramInterface::UPLOADED_IMAGE_URL],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            [InstagramInterface::UPLOADED_IMAGE_URL],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Instagram Data Feed table'
        );

        $setup->getConnection()->createTable($table);
    }
}