<?php

namespace ColbyGatte\HelloWorld\Model;

use ColbyGatte\HelloWorld\Api\Data\PersonInterface;
use ColbyGatte\HelloWorld\Model\PersonFactory;
use ColbyGatte\HelloWorld\Model\ResourceModel\Person\CollectionFactory;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PersonRepository implements \ColbyGatte\HelloWorld\Api\PersonRepositoryInterface
{
    protected $objectFactory;
    
    protected $collectionFactory;
    
    /**
     * @var SearchResultFactory
     */
    protected $searchResultsFactory;
    
    public function __construct(
        PersonFactory $objectFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->objectFactory = $objectFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }
    
    public function save(PersonInterface $object)
    {
        try {
            $object->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        
        return $object;
    }
    
    public function getById($id)
    {
        $object = $this->objectFactory->create();
        $object->load($id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        
        return $object;
    }
    
    public function delete(PersonInterface $object)
    {
        try {
            $object->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        
        return true;
    }
    
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
    
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        
        return $searchResults;
    }
}
