<?php

namespace ColbyGatte\HelloWorld\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface as ModuleContext;
use Magento\Framework\Setup\SchemaSetupInterface as SchemaSetup;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetup $setup, ModuleContext $context)
    {
        $setup->startSetup();
        
        $conn = $setup->getConnection();
        
        $conn->createTable(
            $this->makePersonTable($setup, $conn)
        );
        
        $setup->endSetup();
    }
    
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\DB\Adapter\AdapterInterface $conn
     *
     * @internal param \Magento\Framework\DB\Ddl\Table $table
     *
     * @return Table
     */
    protected function makePersonTable(SchemaSetup $setup, AdapterInterface $conn)
    {
        return $conn
            ->newTable(
                $setup->getTable('colbygatte_helloworld_person')
            )
            ->addColumn(
                'colbygatte_helloworld_person_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Entity ID'
            )
            ->addColumn(
                'title',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false,],
                'Demo Title'
            )
            ->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT,],
                'Creation Time'
            )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE,],
                'Modification Time'
            )
            ->addColumn(
                'is_active',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '1',],
                'Is Active'
            );
    }
}
