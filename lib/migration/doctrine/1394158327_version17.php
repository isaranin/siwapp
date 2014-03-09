<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version17 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('common', 'customer_business_name', 'string', '100', array(
             ));
        $this->addColumn('common', 'customer_mobile', 'string', '20', array(
             ));
        $this->addColumn('common', 'customer_comments', 'clob', '', array(
             ));
        $this->addColumn('common', 'customer_tax_condition', 'string', '10', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('common', 'customer_business_name');
        $this->removeColumn('common', 'customer_mobile');
        $this->removeColumn('common', 'customer_comments');
        $this->removeColumn('common', 'customer_tax_condition');
    }
}