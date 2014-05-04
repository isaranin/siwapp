<?php

/**
 * configuration actions.
 *
 * @package    siwapp
 * @subpackage configuration
 * @author     Leo
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class configurationActions extends sfActions
{
  /**
   * Execute index action
   *
   * @return void
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('@settings');
  }
  
  /**
   * undocumented function
   *
   * @return void
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function executeSettings(sfWebRequest $request)
  {
    $user = $this->getUser();
    $i18n = $this->getContext()->getI18N();
    
    $form = new GlobalSettingsForm(array(),null, array('culture' => $user->getCulture()));
    if ($request->isMethod('post'))
    {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if ($form->isValid())
      {
        $form->save();
        $user->info($i18n->__('Your settings were successfully saved.'));
        $user->loadCompany(sfContext::getInstance()->getUser()->getAttribute('company_id'));
        $user->loadUserSettings();
        
        $this->redirect('@settings');
      }
      else
      {
        $user->error($i18n->__('Settings could not be saved. Please, check entered values and try to correct them.'), false);
      }
    }
    $this->form = $form;
  }

  /**
   * undocumented function
   *
   * @return void
   * @author Sergi Almacellas  <sergi.almacellas@btactic.com>
   **/
  public function executeProductsSettings(sfWebRequest $request)
  {
    $user = $this->getUser();
    $i18n = $this->getContext()->getI18N();
    
    $form = new ProductsSettingsForm(array(),null, array('culture' => $user->getCulture()));
    if ($request->isMethod('post'))
    {
  
      $form->bind($request->getParameter($form->getName()));

      if ($form->isValid())
      {
        $form->save();
        
        $user->info($i18n->__('Your settings were successfully saved.'));
        
        $this->redirect('@products_settings');
      }
      else
      {
        $user->error($i18n->__('Settings could not be saved. Please, check entered values and try to correct them.'), false);
      }
    }
    $this->form = $form;
  }
  
  /**
   * Expenses settings
   * 
   * @param sfWebRequest $request
   * @author Pablo L. Fiumidinisi <plfiumi@gmail.com>
   */
  public function executeExpensesSettings(sfWebRequest $request)
  {
    $user = $this->getUser();
    $i18n = $this->getContext()->getI18N();
    
    $form = new ExpensesSettingsForm(array(),null, array('culture' => $user->getCulture()));
    if ($request->isMethod('post'))
    {
  
      $form->bind($request->getParameter($form->getName()));

      if ($form->isValid())
      {
        $form->save();
        
        $user->info($i18n->__('Your settings were successfully saved.'));
        
        $this->redirect('@expenses_settings');
      }
      else
      {
        $user->error($i18n->__('Settings could not be saved. Please, check entered values and try to correct them.'), false);
      }
    }
    $this->form = $form;
  }
  
  public function executeProfile(sfWebRequest $request)
  {
    $user = $this->getUser();
    $i18n = $this->getContext()->getI18N();
    
    $form = new CurrentUserProfileForm($user->getProfile(), array('user'=>$user));
    
    if ($request->isMethod('post'))
    {
      $config = $request->getParameter('config');
      
      $form->bind($config);
      if ($form->isValid())
      {
        $form->save();
        
        $culture = $config['language'];
        if(isset($config['country'])) 
          $country = $config['country'];
        else
          $country = null;
        
        if ($country) $culture .= '_'.$country;
        $user->setCulture($culture);
        $user->info($i18n->__('Your settings were successfully saved.'));
        
        $this->redirect('@profile');
      }
      else
      {
        $user->error($i18n->__('Settings could not be saved. Please, check entered values and try to correct them.'), false);
      }
    }
    
    $this->form = $form;
  }
  
  public function executeAjaxGetCountries(sfWebRequest $request)
  {
    $this->form = new ProfileForm($this->getUser()->getProfile(), 
      array('user'=>$this->getUser(), 'language'=>$this->getRequestParameter('language')));
    
    if (CultureTools::getCountriesForLanguage($this->getRequestParameter('language')))
    {
      return sfView::SUCCESS;
    }
    else
    {
      return sfView::NONE;
    }
  }
  
  /**
   * Adds a new NameValueForm into the specified location for a 'generic' settings form.
   * @param string to Location where to insert the item
   *                  Ex: config['taxes'][new_1234567890][<name_or_value>]
   *                               |_ 'to' parameter            |_ from NameValueForm
   * @return void
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function executeAddNewNameValueItem(sfWebRequest $request)
  {
    $this->forward404Unless($to = $request->getParameter('to'));
    
    $configForm    = new sfForm();
    $configForm->getWidgetSchema()->setNameFormat('config[%s]');
    $index   = 'new_'.time();
    
    switch($to)
    {
      case 'taxes':
        $subform = new FormsContainer(array($index=>new TaxForm()),'TaxForm');
        break;
      case 'seriess':
        $subform = new FormsContainer(array($index=>new SeriesForm()),'SeriesForm');
        break;
      case 'expenses':
        $configForm->getWidgetSchema()->setNameFormat('expenses_settings[%s]');
        $subform = new FormsContainer(array($index=>new ExpenseTypeForm()),'ExpenseTypeForm');
        break;
      case 'payments':
        $subform = new FormsContainer(array($index=>new PaymentTypeForm()),'PaymentTypeForm');
        break;  
      case 'taxConditions':
        $subform = new FormsContainer(array($index=>new TaxConditionForm()),'TaxConditionForm');
        break;  
      case 'product_categories':
        $configForm->getWidgetSchema()->setNameFormat('products_settings[%s]');
        $subform = new FormsContainer(array($index=>new ProductCategoryForm()),'ProductCategoryForm');
        break;  
    }
    $configForm->embedForm($to, $subform);
    return $this->renderText($configForm[$to][$index]);
  }

}
