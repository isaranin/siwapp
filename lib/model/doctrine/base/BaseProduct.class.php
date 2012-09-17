<?php

/**
 * BaseProduct
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $reference
 * @property clob $description
 * @property decimal $price
 * @property integer $category_id
 * @property ProductCategory $ProductCategory
 * @property Doctrine_Collection $Items
 * 
 * @method string              getReference()       Returns the current record's "reference" value
 * @method clob                getDescription()     Returns the current record's "description" value
 * @method decimal             getPrice()           Returns the current record's "price" value
 * @method integer             getCategoryId()      Returns the current record's "category_id" value
 * @method ProductCategory     getProductCategory() Returns the current record's "ProductCategory" value
 * @method Doctrine_Collection getItems()           Returns the current record's "Items" collection
 * @method Product             setReference()       Sets the current record's "reference" value
 * @method Product             setDescription()     Sets the current record's "description" value
 * @method Product             setPrice()           Sets the current record's "price" value
 * @method Product             setCategoryId()      Sets the current record's "category_id" value
 * @method Product             setProductCategory() Sets the current record's "ProductCategory" value
 * @method Product             setItems()           Sets the current record's "Items" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProduct extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product');
        $this->hasColumn('reference', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('price', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'notnull' => true,
             'default' => 0,
             'length' => 53,
             ));
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ProductCategory', array(
             'local' => 'category_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasMany('Item as Items', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}