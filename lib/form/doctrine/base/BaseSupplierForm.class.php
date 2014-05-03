<?php

/**
 * Supplier form base class.
 *
 * @method Supplier getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSupplierForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'company_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'name'                     => new sfWidgetFormInputText(),
      'name_slug'                => new sfWidgetFormInputText(),
      'business_name'            => new sfWidgetFormInputText(),
      'identification'           => new sfWidgetFormInputText(),
      'email'                    => new sfWidgetFormInputText(),
      'contact_person'           => new sfWidgetFormInputText(),
      'contact_person_phone'     => new sfWidgetFormInputText(),
      'contact_person_email'     => new sfWidgetFormInputText(),
      'invoicing_address'        => new sfWidgetFormInputText(),
      'invoicing_postalcode'     => new sfWidgetFormInputText(),
      'invoicing_city'           => new sfWidgetFormInputText(),
      'invoicing_state'          => new sfWidgetFormInputText(),
      'invoicing_country'        => new sfWidgetFormInputText(),
      'website'                  => new sfWidgetFormInputText(),
      'phone'                    => new sfWidgetFormInputText(),
      'mobile'                   => new sfWidgetFormInputText(),
      'fax'                      => new sfWidgetFormInputText(),
      'comments'                 => new sfWidgetFormTextarea(),
      'tax_condition'            => new sfWidgetFormInputText(),
      'financial_entity'         => new sfWidgetFormInputText(),
      'financial_entity_office'  => new sfWidgetFormInputText(),
      'financial_entity_account' => new sfWidgetFormInputText(),
      'payment_type_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'), 'add_empty' => true)),
      'login'                    => new sfWidgetFormInputText(),
      'password'                 => new sfWidgetFormInputText(),
      'expense_type_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'name'                     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name_slug'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'business_name'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'identification'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'                    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contact_person'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contact_person_phone'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'contact_person_email'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'invoicing_address'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'invoicing_postalcode'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'invoicing_city'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'invoicing_state'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'invoicing_country'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'                    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'mobile'                   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'                      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'comments'                 => new sfValidatorString(array('required' => false)),
      'tax_condition'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'financial_entity'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'financial_entity_office'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'financial_entity_account' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'payment_type_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'), 'required' => false)),
      'login'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'password'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'expense_type_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('supplier[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Supplier';
  }

}
