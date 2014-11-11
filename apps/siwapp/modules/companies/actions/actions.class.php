<?php

/**
 * Companys actions.
 *
 * @package    siwapp
 * @subpackage invoices
 * @author     Siwapp Team
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class CompaniesActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->culture  = $this->getUser()->getCulture();
    $this->usersCreated = ProfileTable::getUsersCreated();
    
    /*
     * Delete can_create_companies permission if user arrives to
     * maximum allowed.
     */
    $companiesCount = Doctrine_Query::create()
        ->select('cu.company_id,c.name')
        ->from('CompanyUser cu')
        ->innerJoin('cu.Company c')
        ->where('sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
        ->orWhereIn('sf_guard_user_id',$this->usersCreated)
        ->count();

      if($this->getUser()->hasGroup('professional')) {
        if ($companiesCount > 2) {
          $this->getUser()->removeCredential('can_create_companies');
        } else {
          if (!$this->getUser()->hasCredential('can_create_companies'))
            $this->getUser()->addCredential('can_create_companies');
        }
      }

      if($this->getUser()->hasGroup('corporate')) {
        if ($companiesCount > 9) {
          $this->getUser()->removeCredential('can_create_companies');
        } else {
          if (!$this->getUser()->hasCredential('can_create_companies'))
            $this->getUser()->addCredential('can_create_companies');
        }
      }
      
      if (!$this->getUser()->isSuperAdmin()) {
        $userCompaniesData = Doctrine_Query::create()
          ->select('cu.company_id')
          ->from('CompanyUser cu')
          ->innerJoin('cu.Company c')
          ->where('sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
          ->orWhereIn('sf_guard_user_id',$this->usersCreated)
          ->orderBy("c.name ASC")->fetchArray();

        foreach($userCompaniesData as $userCompany)
        {
          $userCompanies[] = $userCompany['company_id'];
        }
        $this->userCompanies = $userCompanies;
      }
  }
  
  private function getCompany(sfWebRequest $request)
  {
    $this->forward404Unless($Company = Doctrine::getTable('Company')->find($request->getParameter('id')),
      sprintf('Object Company does not exist with id %s', $request->getParameter('id')));
      
    if (!$this->getUser()->isSuperAdmin()) {
      $this->forward404Unless(in_array($request->getParameter('id'), $this->userCompanies));
    }
    return $Company;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $namespace  = $request->getParameter('searchNamespace');
    $search     = $this->getUser()->getAttribute('search', null, $namespace);
    $sort       = $this->getUser()->getAttribute('sort', array('name', 'asc'), $namespace);
    $page       = $this->getUser()->getAttribute('page', 1, $namespace);
    $maxResults = $this->getUser()->getPaginationMaxResults();
    
    if (!$this->getUser()->isSuperAdmin()) {
      $q = CompanyQuery::create()->search($search)->whereIn('id',$this->userCompanies)
        ->orderBy("$sort[0] $sort[1], name $sort[1]");
    } else {
      $q = CompanyQuery::create()->search($search)
        ->orderBy("$sort[0] $sort[1], name $sort[1]");
    }

    $this->pager = new sfDoctrinePager('Company', $maxResults);
    $this->pager->setQuery($q);
    $this->pager->setPage($page);
    $this->pager->init();
   
    $this->getUser()->setAttribute('page', $request->getParameter('page'));
    
    $this->sort = $sort;
  }

  public function executeNew(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $Company = new Company();
    $Company->fromArray(array(
                          'currency' => 'EUR',
                          'pdf_size' => 'a4',
                          ));
    
    $this->companyForm = new CompanyForm($Company, array('culture'=>$this->culture));
    $this->title       = $i18n->__('New Company');
    $this->action      = 'create';
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->companyForm = new CompanyForm(null, array('culture' => $this->culture));
    $this->title = $this->getContext()->getI18N()->__('New Company');
    $this->action = 'create';

    $this->processForm($request, $this->companyForm);
    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $Company = $this->getCompany($request);

    $this->companyForm = new CompanyForm($Company, array('culture'=>$this->culture));
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Company');
    $this->action = 'update';
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $company_params = $request->getParameter('company');
    $request->setParameter('id', $company_params['id']);
    $this->forward404Unless($request->isMethod('post'));
    $Company = $this->getCompany($request);
    
    $this->companyForm = new CompanyForm($Company, array('culture'=>$this->culture));
    $this->processForm($request, $this->companyForm);
    
    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Company');
    $this->action = 'update';
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $Company = $this->getCompany($request);
    if(!$Company->delete())
    {
      $this->getUser()->error($this->getContext()->getI18N()
                              ->__('The Company could not be deleted. '
                                   .'Probably because an associated invoice exists')
                              );
    }

    $this->redirect('companies/index');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = $this->getContext()->getI18N();
    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $template = 'The Company was %s successfully %s.';
      $message  = $form->getObject()->isNew() ? 'created' : 'updated';
      $suffix   = null;
      $method   = 'info';
      
      $company = $form->save();
      
      $this->getUser()->$method($i18n->__(sprintf($template, $message, $suffix)));
      $this->redirect('companies/edit?id='.$company->id);
    }
    else
    {
      $this->getUser()->error($i18n->__('The Company has not been saved due to some errors.'));
    }
  }
  
  /**
   * batch actions
   *
   * @return void
   **/
  public function executeBatch(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $form = new sfForm();
    $form->bind(array('_csrf_token' => $request->getParameter('_csrf_token')));

    //TO REVIEW MCY the use of a pseudo conditionals switch looks really suspect

    if($form->isValid() || $this->getContext()->getConfiguration()->getEnvironment() == 'test')
    {
      $n = 0;
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($Company = Doctrine::getTable('Company')->find($id))
        {
          switch($request->getParameter('batch_action'))
          {
            case 'delete':
              if ($Company->delete()) $n++;
              break;
          }
        }
      }
      switch($request->getParameter('batch_action'))
      {
        case 'delete':
          $this->getUser()->info(sprintf($i18n->__('%d Companys were successfully deleted.'), $n));
          break;
      }
    }

    $this->redirect('companies');
  }

  public function executeChange(sfWebRequest $request)
  {
    $this->getUser()->loadCompany($request->getParameter('id'));
    $this->redirect('dashboard');    
  }

}
