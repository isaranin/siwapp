<?php

/**
 * BaseEstimate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Doctrine_Collection $Estimate
 * 
 * @method Doctrine_Collection getEstimate() Returns the current record's "Estimate" collection
 * @method Estimate            setEstimate() Sets the current record's "Estimate" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEstimate extends Common
{
    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Invoice as Estimate', array(
             'local' => 'id',
             'foreign' => 'estimate_id'));
    }
}