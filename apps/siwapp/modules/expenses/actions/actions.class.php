<?php

/**
 * expenses actions.
 *
 * @package    siwapp
 * @subpackage expenses
 * @author     Siwapp Team
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class expensesActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->culture  = $this->getUser()->getCulture();
  }

  private function getExpense(sfWebRequest $request)
  {
    $this->forward404Unless($invoice = Doctrine::getTable('Expense')->find($request->getParameter('id')),
      sprintf('Object invoice does not exist with id %s', $request->getParameter('id')));
    
    $this->forward404Unless($invoice->getCompanyId() == $this->getUser()->getAttribute('company_id'),
      sprintf('Object invoice does not exist with id %s', $request->getParameter('id')));

    return $invoice;
  }

  public function executeIndex(sfWebRequest $request)
  {
    $namespace  = $request->getParameter('searchNamespace');
    $search     = $this->getUser()->getAttribute('search', null, $namespace);
    $sort       = $this->getUser()->getAttribute('sort', array('issue_date', 'desc'), $namespace);
    $page       = $this->getUser()->getAttribute('page', 1, $namespace);
    $maxResults = $this->getUser()->getPaginationMaxResults();

    $q = ExpenseQuery::create()->Where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->search($search)->orderBy("$sort[0] $sort[1], number $sort[1]");
    // totals
    $this->gross = $q->total('gross_amount');
    $this->due   = $q->total('due_amount');

    $this->pager = new sfDoctrinePager('Expense', $maxResults);
    $this->pager->setQuery($q);
    $this->pager->setPage($page);
    $this->pager->init();

    // this is for the redirect of the payments forms
    $this->getUser()->setAttribute('module', $request->getParameter('module'));
    $this->getUser()->setAttribute('page', $request->getParameter('page'));

    $this->sort = $sort;
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->invoice = $this->getExpense($request);
  }

  public function executeNew(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $expense = new Expense();

    $this->invoiceForm = new ExpenseForm($expense, array('culture'=>$this->culture));
    $this->title       = $i18n->__('New Expense');
    $this->action      = 'create';
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->invoiceForm = new ExpenseForm(null, array('culture' => $this->culture));
    $this->title = $this->getContext()->getI18N()->__('New Expense');
    $this->action = 'create';

    $this->processForm($request, $this->invoiceForm);
    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $invoice = $this->getExpense($request);

    // if the invoice is not a draft, forward to the show action unless the referer is edit or show
    if($invoice->status != Expense::DRAFT)
    {
      $comes_from_edit = substr_count($request->getReferer(), '/edit') > 0 ? true : false;
      $this->forwardIf(!$comes_from_edit, 'expenses', 'show');
    }
    // save the original draft state
    $this->db_draft = $invoice->draft;
    // set draft=0 by default always
    $invoice->setDraft(false);
    $this->invoiceForm = new ExpenseForm($invoice, array('culture'=>$this->culture));

    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Expense').' '.$invoice;
    $this->action = 'update';
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $invoice_params = $request->getParameter('expense');
    $request->setParameter('id', $invoice_params['id']);
    $this->forward404Unless($request->isMethod('post'));
    $invoice = $this->getExpense($request);
    $this->invoiceForm = new ExpenseForm($invoice, array('culture'=>$this->culture));
    $this->processForm($request, $this->invoiceForm);

    $i18n = $this->getContext()->getI18N();
    $this->title = $i18n->__('Edit Expense');
    $this->action = 'update';

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $invoice = $this->getExpense($request);
    $invoice->delete();

    $this->redirect('expenses/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = $this->getContext()->getI18N();
    $invoice_params = $request->getParameter($form->getName());
    $form->bind($invoice_params, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $invoice = $form->save();
      $invoice->setDraft((int) $invoice_params['draft']);
      $invoice->save();
      // update totals with saved values
      $invoice->refresh(true)->setAmounts()->save();

      $this->getUser()->info($i18n->__('The expense was successfully saved.'));
      $this->redirect('expenses/edit?id='.$invoice->id);
    }
    else
    {
      $this->getUser()->error($i18n->__('The expense has not been saved due to some errors.'));
    }
  }

  /**
   * batch actions
   *
   * @return void
   **/
  public function executeExport(sfWebRequest $request)
  {
      $n = 0;
      $objPHPExcel = new sfPhpExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      //Generate Headers.
      $objPHPExcel->getActiveSheet()->setTitle('GASTOS');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TIPO');
      $objPHPExcel->getActiveSheet()->setCellValue('B1', 'FECHA');
      $objPHPExcel->getActiveSheet()->setCellValue('C1', 'FECHA VENCIMIENTO');
      $objPHPExcel->getActiveSheet()->setCellValue('D1', 'REGISTRO');
      $objPHPExcel->getActiveSheet()->setCellValue('E1', 'DESCRIPCIÓN');
      $objPHPExcel->getActiveSheet()->setCellValue('F1', 'IDENTIFICACION PROVEEDOR');
      $objPHPExcel->getActiveSheet()->setCellValue('G1', 'NOMBRE PROVEEDOR');
      $objPHPExcel->getActiveSheet()->setCellValue('H1', 'SUBTOTAL');
      $objPHPExcel->getActiveSheet()->setCellValue('I1', 'DESCUENTO');
      $objPHPExcel->getActiveSheet()->setCellValue('J1', 'BASE IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('K1', '%IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('L1', 'IMPORTE IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('M1', 'BASE IVA 2');
      $objPHPExcel->getActiveSheet()->setCellValue('N1', '%IVA 2');
      $objPHPExcel->getActiveSheet()->setCellValue('O1', 'IMPORTE IVA 2');
      $objPHPExcel->getActiveSheet()->setCellValue('P1', 'BASE IVA 3');
      $objPHPExcel->getActiveSheet()->setCellValue('Q1', '%IVA 3');
      $objPHPExcel->getActiveSheet()->setCellValue('R1', 'IMPORTE IVA 3');
      $objPHPExcel->getActiveSheet()->setCellValue('S1', 'TOTAL IVA');
      $objPHPExcel->getActiveSheet()->setCellValue('T1', 'TOTAL');
      
      $objPHPExcel->getActiveSheet()->setCellValue('U1', 'PAIS');
      $objPHPExcel->getActiveSheet()->setCellValue('V1', 'PROVINCIA');
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($invoice = Doctrine::getTable('Expense')->find($id))
        {
              $type = '';
              foreach ($invoice->getGrupedExpenseTypes() as $expenseType => $value)
              {
                  $type=$expenseType;
              }
            $taxes = array();
            for($i=0; $i<15; $i++){
                $taxes[] = 0;
            }
            $retencion = array();
            for($i=0; $i<4; $i++){
                $retencion[] = 0;
            }

            $total = 0;

            $i=0; $j=0;
            foreach ($invoice->getGrupedTaxes() as $tax => $value)
            {
                $taxes[$i] = $value['base'];
                $i++;
                $taxes[$i] = $value['tax_value'];
                $i++;
                $taxes[$i] = $value['tax'];
                $i++;
                $taxes[$i] = 0;
                $i++;
                $taxes[$i] = 0;
                $i++;
                $total = $value['total'];
                $retencion[$j] = abs($value['retencion_value']);
                $j++;
                $retencion[$j] = abs($value['retencion']);
                $j++;
            }
              $objPHPExcel->getActiveSheet()->setCellValue('A'. ($n+2),$type); //CUENTA
              $objPHPExcel->getActiveSheet()->setCellValue('B'. ($n+2),date('d/m/Y',strtotime($invoice->getIssueDate()))); //FECHA
              $objPHPExcel->getActiveSheet()->setCellValue('C'. ($n+2),($invoice->getDueDate()) ? date('d/m/Y',strtotime($invoice->getDueDate())) : ""); //FECHA VENCIMIENTO
              $objPHPExcel->getActiveSheet()->setCellValue('D'. ($n+2), $invoice.''); //REGISTRO
              $objPHPExcel->getActiveSheet()->setCellValue('E'. ($n+2), 'FACTURA '.$invoice); //DESCRIPCIÓN
              $objPHPExcel->getActiveSheet()->setCellValue('F'. ($n+2), $invoice->getSupplierIdentification()); //IDENTIFICACION CLIENTE
              $objPHPExcel->getActiveSheet()->setCellValue('G'. ($n+2), $invoice->getSupplierName()); //NOMBRE CLIENTE
              $objPHPExcel->getActiveSheet()->setCellValue('H'. ($n+2), $invoice->getBaseAmount()); //SUBTOTAL
              $objPHPExcel->getActiveSheet()->setCellValue('I'. ($n+2), $invoice->getDiscountAmount()); //DESCUENTO
              $objPHPExcel->getActiveSheet()->setCellValue('J'. ($n+2),  $taxes[0]); //BASE IVA
              $objPHPExcel->getActiveSheet()->setCellValue('K'. ($n+2), $taxes[1]); //%IVA
              $objPHPExcel->getActiveSheet()->setCellValue('L'. ($n+2), $taxes[2]); //IMPORTE IVA
              $objPHPExcel->getActiveSheet()->setCellValue('M'. ($n+2),  $taxes[5]); //BASE IVA 2
              $objPHPExcel->getActiveSheet()->setCellValue('N'. ($n+2), $taxes[6]); //%IVA 2
              $objPHPExcel->getActiveSheet()->setCellValue('O'. ($n+2), $taxes[7]); //IMPORTE IVA 2
              $objPHPExcel->getActiveSheet()->setCellValue('P'. ($n+2),  $taxes[10]); //BASE IVA 3
              $objPHPExcel->getActiveSheet()->setCellValue('Q'. ($n+2), $taxes[11]); //%IVA 3
              $objPHPExcel->getActiveSheet()->setCellValue('R'. ($n+2), $taxes[12]); //IMPORTE IVA 3
              $objPHPExcel->getActiveSheet()->setCellValue('S'. ($n+2), $taxes[2]+$taxes[7]+$taxes[12]); //TOTAL IVA
              $objPHPExcel->getActiveSheet()->setCellValue('T'. ($n+2), $invoice->getGrossAmount()); //TOTAL
              
              $objPHPExcel->getActiveSheet()->setCellValue('U'. ($n+2), $invoice->getSupplier()->getInvoicingCountry()); //PAIS
              $objPHPExcel->getActiveSheet()->setCellValue('V'. ($n+2), $invoice->getSupplier()->getInvoicingState()); //PROVINCIA
              $n++;
        }
      }

    $this->setLayout(false);
    $response = $this->getContext()->getResponse();
    $response->clearHttpHeaders();
    $response->setHttpHeader('Content-Type', 'application/vnd.ms-excel;charset=utf-8');
    $response->setHttpHeader('Content-Disposition:', 'attachment;filename=export.xls');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_start();
    $objWriter->save('php://output');
    $response->setContent(ob_get_clean());
    return sfView::NONE;
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

    if($form->isValid() || $this->getContext()->getConfiguration()->getEnvironment() == 'test')
    {
      $n = 0;
      foreach($request->getParameter('ids', array()) as $id)
      {
        if($invoice = Doctrine::getTable('Expense')->find($id))
        {
          switch($request->getParameter('batch_action'))
          {
            case 'delete':
              if ($invoice->delete()) $n++;
              break;
          }
        }
      }
      switch($request->getParameter('batch_action'))
      {
        case 'delete':
          $this->getUser()->info(sprintf($i18n->__('%d expenses were successfully deleted.'), $n));
          break;
      }
    }

    $this->redirect('@expenses');
  }

}
