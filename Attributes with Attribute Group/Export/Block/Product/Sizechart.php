<?php
namespace Ahaomar\Export\Block\Product;
class Sizechart extends \Magento\Framework\View\Element\Template
{
    protected $_coreRegistry;
    protected $_productloader;
    protected $request;
    protected $_groupCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $_productloader,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $_groupCollection,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry
    ){
        $this->_coreRegistry = $registry;
        $this->_productloader = $_productloader;
        $this->request = $request;
        $this->_groupCollection = $_groupCollection;
        parent::__construct($context);
    }

    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }


    public function getMyname()
    {
        return "Omar farooq";
    }


//get the product
    public function getLoadProduct()
    {
          $id=1;
     
        return $this->_productloader->create()->load($id);
    }
//Get attribute group id
    public function getAttributeGroupId($attributeSetId)
    {
         $groupCollection = $this->_groupCollection->create();
         $groupCollection->addFieldToFilter('attribute_set_id',$attributeSetId);
         $groupCollection->addFieldToFilter('attribute_group_name','Grid Attributes');
         
         
         return $groupCollection->getFirstItem();

    }
    //Get all attribute groups
    public function getAttributeGroups($attributeSetId)
    {
         $groupCollection = $this->_groupCollection->create();
         $groupCollection->addFieldToFilter('attribute_set_id',$attributeSetId);
         
         $groupCollection->setOrder('sort_order','ASC');
         return $groupCollection;

    }
//get attribute by groups
 public function getGroupAttributes($pro,$groupId, $productAttributes){
        $data=[];
        $no =__('No');
        foreach ($productAttributes as $attribute){
   
          if ($attribute->isInGroup($pro->getAttributeSetId(), $groupId) && $attribute->getIsVisibleOnFront() ){
              if($attribute->getFrontend()->getValue($pro) && $attribute->getFrontend()->getValue($pro)!='' && $attribute->getFrontend()->getValue($pro)!=$no){
                $data[]=$attribute;
              }
          }

        }
 
  return $data;
 }

}