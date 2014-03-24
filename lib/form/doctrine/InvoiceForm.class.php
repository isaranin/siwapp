<?php

/**
 * Invoice form.
 *
 * @package    form
 * @subpackage Invoice
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class InvoiceForm extends CommonForm
{
  protected $number;

  public function configure($expense = false)
  {
    unset($this['number'], $this['created_at'], $this['updated_at']);
    // we unset paid_amount so the system don't "nullify" the field on every invoice editing.
    unset($this['paid_amount']);


    $this->number = $this->getObject()->getNumber();
    $this->widgetSchema['issue_date'] =
      new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['due_date']   =
      new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['draft']      = new sfWidgetFormInputHidden();
    $this->widgetSchema['closed']->setLabel('Force to be closed');
    $this->widgetSchema['discount']->setLabel('Global Discount');

    $this->widgetSchema['sent_by_email']->setLabel('Sent by email');

    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
    
    $this->setDefaults(array(
      'issue_date'              => time(),
      'draft'                   => 0,
      'terms'                   => $companyObject->getInvoiceLegalTerms()
      ));
    
    $this->validatorSchema['payment_type_id'] = new sfValidatorString(array('required' => true));
    $this->widgetSchema->setNameFormat('invoice[%s]');

    parent::configure();
  }

  public function getModelName()
  {
    return 'Invoice';
  }

}
