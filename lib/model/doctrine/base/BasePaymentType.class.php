<?php

/**
 * BasePaymentType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property boolean $enabled
 * @property Doctrine_Collection $PaymentType
 * 
 * @method string              getName()        Returns the current record's "name" value
 * @method boolean             getEnabled()     Returns the current record's "enabled" value
 * @method Doctrine_Collection getPaymentType() Returns the current record's "PaymentType" collection
 * @method PaymentType         setName()        Sets the current record's "name" value
 * @method PaymentType         setEnabled()     Sets the current record's "enabled" value
 * @method PaymentType         setPaymentType() Sets the current record's "PaymentType" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePaymentType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('payment_type');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('enabled', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));

        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Common as PaymentType', array(
             'local' => 'id',
             'foreign' => 'payment_type_id'));
    }
}