<?php

namespace ColbyGatte\HelloWorld\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Person extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('colbygatte_helloworld_person', 'colbygatte_helloworld_person_id');
    }
}