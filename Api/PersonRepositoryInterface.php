<?php
namespace ColbyGatte\HelloWorld\Api;

use ColbyGatte\HelloWorld\Api\Data\PersonInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PersonRepositoryInterface 
{
    public function save(PersonInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(PersonInterface $page);

    public function deleteById($id);
}
