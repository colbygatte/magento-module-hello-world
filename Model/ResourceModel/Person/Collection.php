<?php
namespace ColbyGatte\HelloWorld\Model\ResourceModel\Person;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('ColbyGatte\HelloWorld\Model\Person','ColbyGatte\HelloWorld\Model\ResourceModel\Person');
    }
}
