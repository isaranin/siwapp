<?php

/**
 * BaseCustomer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property string $name
 * @property string $name_slug
 * @property string $business_name
 * @property string $identification
 * @property string $email
 * @property clob $shipping_company_data
 * @property string $contact_person
 * @property string $contact_person_phone
 * @property string $contact_person_email
 * @property string $invoicing_address
 * @property string $invoicing_postalcode
 * @property string $invoicing_city
 * @property string $invoicing_state
 * @property string $invoicing_country
 * @property integer $series_id
 * @property string $shipping_address
 * @property string $shipping_postalcode
 * @property string $shipping_city
 * @property string $shipping_state
 * @property string $shipping_country
 * @property string $website
 * @property string $phone
 * @property string $mobile
 * @property string $fax
 * @property clob $comments
 * @property integer $tax_condition_id
 * @property string $financial_entity
 * @property string $financial_entity_office
 * @property string $financial_entity_control_digit
 * @property string $financial_entity_account
 * @property string $financial_entity_bic
 * @property string $financial_entity_iban
 * @property integer $payment_type_id
 * @property decimal $discount
 * @property Company $Company
 * @property PaymentType $PaymentType
 * @property Series $Series
 * @property TaxCondition $TaxCondition
 * @property Doctrine_Collection $Commons
 * 
 * @method integer             getCompanyId()                      Returns the current record's "company_id" value
 * @method string              getName()                           Returns the current record's "name" value
 * @method string              getNameSlug()                       Returns the current record's "name_slug" value
 * @method string              getBusinessName()                   Returns the current record's "business_name" value
 * @method string              getIdentification()                 Returns the current record's "identification" value
 * @method string              getEmail()                          Returns the current record's "email" value
 * @method clob                getShippingCompanyData()            Returns the current record's "shipping_company_data" value
 * @method string              getContactPerson()                  Returns the current record's "contact_person" value
 * @method string              getContactPersonPhone()             Returns the current record's "contact_person_phone" value
 * @method string              getContactPersonEmail()             Returns the current record's "contact_person_email" value
 * @method string              getInvoicingAddress()               Returns the current record's "invoicing_address" value
 * @method string              getInvoicingPostalcode()            Returns the current record's "invoicing_postalcode" value
 * @method string              getInvoicingCity()                  Returns the current record's "invoicing_city" value
 * @method string              getInvoicingState()                 Returns the current record's "invoicing_state" value
 * @method string              getInvoicingCountry()               Returns the current record's "invoicing_country" value
 * @method integer             getSeriesId()                       Returns the current record's "series_id" value
 * @method string              getShippingAddress()                Returns the current record's "shipping_address" value
 * @method string              getShippingPostalcode()             Returns the current record's "shipping_postalcode" value
 * @method string              getShippingCity()                   Returns the current record's "shipping_city" value
 * @method string              getShippingState()                  Returns the current record's "shipping_state" value
 * @method string              getShippingCountry()                Returns the current record's "shipping_country" value
 * @method string              getWebsite()                        Returns the current record's "website" value
 * @method string              getPhone()                          Returns the current record's "phone" value
 * @method string              getMobile()                         Returns the current record's "mobile" value
 * @method string              getFax()                            Returns the current record's "fax" value
 * @method clob                getComments()                       Returns the current record's "comments" value
 * @method integer             getTaxConditionId()                 Returns the current record's "tax_condition_id" value
 * @method string              getFinancialEntity()                Returns the current record's "financial_entity" value
 * @method string              getFinancialEntityOffice()          Returns the current record's "financial_entity_office" value
 * @method string              getFinancialEntityControlDigit()    Returns the current record's "financial_entity_control_digit" value
 * @method string              getFinancialEntityAccount()         Returns the current record's "financial_entity_account" value
 * @method string              getFinancialEntityBic()             Returns the current record's "financial_entity_bic" value
 * @method string              getFinancialEntityIban()            Returns the current record's "financial_entity_iban" value
 * @method integer             getPaymentTypeId()                  Returns the current record's "payment_type_id" value
 * @method decimal             getDiscount()                       Returns the current record's "discount" value
 * @method Company             getCompany()                        Returns the current record's "Company" value
 * @method PaymentType         getPaymentType()                    Returns the current record's "PaymentType" value
 * @method Series              getSeries()                         Returns the current record's "Series" value
 * @method TaxCondition        getTaxCondition()                   Returns the current record's "TaxCondition" value
 * @method Doctrine_Collection getCommons()                        Returns the current record's "Commons" collection
 * @method Customer            setCompanyId()                      Sets the current record's "company_id" value
 * @method Customer            setName()                           Sets the current record's "name" value
 * @method Customer            setNameSlug()                       Sets the current record's "name_slug" value
 * @method Customer            setBusinessName()                   Sets the current record's "business_name" value
 * @method Customer            setIdentification()                 Sets the current record's "identification" value
 * @method Customer            setEmail()                          Sets the current record's "email" value
 * @method Customer            setShippingCompanyData()            Sets the current record's "shipping_company_data" value
 * @method Customer            setContactPerson()                  Sets the current record's "contact_person" value
 * @method Customer            setContactPersonPhone()             Sets the current record's "contact_person_phone" value
 * @method Customer            setContactPersonEmail()             Sets the current record's "contact_person_email" value
 * @method Customer            setInvoicingAddress()               Sets the current record's "invoicing_address" value
 * @method Customer            setInvoicingPostalcode()            Sets the current record's "invoicing_postalcode" value
 * @method Customer            setInvoicingCity()                  Sets the current record's "invoicing_city" value
 * @method Customer            setInvoicingState()                 Sets the current record's "invoicing_state" value
 * @method Customer            setInvoicingCountry()               Sets the current record's "invoicing_country" value
 * @method Customer            setSeriesId()                       Sets the current record's "series_id" value
 * @method Customer            setShippingAddress()                Sets the current record's "shipping_address" value
 * @method Customer            setShippingPostalcode()             Sets the current record's "shipping_postalcode" value
 * @method Customer            setShippingCity()                   Sets the current record's "shipping_city" value
 * @method Customer            setShippingState()                  Sets the current record's "shipping_state" value
 * @method Customer            setShippingCountry()                Sets the current record's "shipping_country" value
 * @method Customer            setWebsite()                        Sets the current record's "website" value
 * @method Customer            setPhone()                          Sets the current record's "phone" value
 * @method Customer            setMobile()                         Sets the current record's "mobile" value
 * @method Customer            setFax()                            Sets the current record's "fax" value
 * @method Customer            setComments()                       Sets the current record's "comments" value
 * @method Customer            setTaxConditionId()                 Sets the current record's "tax_condition_id" value
 * @method Customer            setFinancialEntity()                Sets the current record's "financial_entity" value
 * @method Customer            setFinancialEntityOffice()          Sets the current record's "financial_entity_office" value
 * @method Customer            setFinancialEntityControlDigit()    Sets the current record's "financial_entity_control_digit" value
 * @method Customer            setFinancialEntityAccount()         Sets the current record's "financial_entity_account" value
 * @method Customer            setFinancialEntityBic()             Sets the current record's "financial_entity_bic" value
 * @method Customer            setFinancialEntityIban()            Sets the current record's "financial_entity_iban" value
 * @method Customer            setPaymentTypeId()                  Sets the current record's "payment_type_id" value
 * @method Customer            setDiscount()                       Sets the current record's "discount" value
 * @method Customer            setCompany()                        Sets the current record's "Company" value
 * @method Customer            setPaymentType()                    Sets the current record's "PaymentType" value
 * @method Customer            setSeries()                         Sets the current record's "Series" value
 * @method Customer            setTaxCondition()                   Sets the current record's "TaxCondition" value
 * @method Customer            setCommons()                        Sets the current record's "Commons" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCustomer extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('customer');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('name_slug', 'string', 120, array(
             'type' => 'string',
             'length' => 120,
             ));
        $this->hasColumn('business_name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('identification', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('shipping_company_data', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('contact_person', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('contact_person_phone', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('contact_person_email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('invoicing_address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('invoicing_postalcode', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('invoicing_city', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('invoicing_state', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('invoicing_country', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('series_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('shipping_address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('shipping_postalcode', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('shipping_city', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('shipping_state', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('shipping_country', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('website', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('phone', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('mobile', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('fax', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('comments', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('tax_condition_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('financial_entity', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('financial_entity_office', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('financial_entity_control_digit', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('financial_entity_account', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('financial_entity_bic', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('financial_entity_iban', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('payment_type_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('discount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 2,
             'notnull' => true,
             'default' => 0,
             'length' => 53,
             ));


        $this->index('cstm', array(
             'fields' => 
             array(
              0 => 'company_id',
              1 => 'name',
             ),
             ));
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('PaymentType', array(
             'local' => 'payment_type_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('Series', array(
             'local' => 'series_id',
             'foreign' => 'id',
             'onDelete' => 'set null'));

        $this->hasOne('TaxCondition', array(
             'local' => 'tax_condition_id',
             'foreign' => 'id',
             'onDelete' => 'set null'));

        $this->hasMany('Common as Commons', array(
             'local' => 'id',
             'foreign' => 'customer_id'));

        $taggable0 = new Taggable();
        $this->actAs($taggable0);
    }
}