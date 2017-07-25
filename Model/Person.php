<?php

namespace ColbyGatte\HelloWorld\Model;

use ColbyGatte\HelloWorld\Api\Data\PersonInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Person extends AbstractModel implements PersonInterface, IdentityInterface
{
    const CACHE_TAG = 'colbygatte_helloworld_person';
    
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }
    
    protected function _construct()
    {
        $this->_init('ColbyGatte\HelloWorld\Model\ResourceModel\Person');
    }
}
