<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version18 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('customer', 'invoicing_series');
        $this->addColumn('customer', 'series_id', 'integer', '8', array(
             ));
    }

    public function down()
    {
        $this->addColumn('customer', 'invoicing_series', 'string', '10', array(
             ));
        $this->removeColumn('customer', 'series_id');
    }
}