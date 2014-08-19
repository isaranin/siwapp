<?php
use_helper('JavascriptBase', 'Number', 'Siwapp', 'Date');

$invoices = $pager->getResults();
$csrf     = new sfForm();
?>

<div class="content">
  
  <?php if (count($invoices)): ?>
    
    <?php echo form_tag('invoices/batch', 'id=batch_form class=batch') ?>
      <?php echo $csrf['_csrf_token']->render(); ?>
      <input type="hidden" name="batch_action" id="batch_action">

      <table class="listing">
        
        <thead>
          <tr>
            <td colspan="5" class="listing-options noborder">
              <?php include_partial('batchActions')?>
            </td>
            <td class="strong noborder"><?php echo __('Total') ?></td>
            <td class="totalDue strong noborder right"><?php echo format_currency($due, $currency) ?></td>
            <td class="strong noborder right"><?php echo format_currency($gross, $currency) ?></td>
            <td colspan="1000" class="noborder"></td>
          </tr>
          <tr class="empty noborder">
            <td colspan="1000"></td>
          </tr>
          <tr>
            <th class="xs"><input id="select_all" rel="all" type="checkbox" name="select_all"></th>
            <?php
              // sort parameter => array (Name, default order)
              renderHeaders(array(
                'series_id'        => array('Serie', 'desc'),
                'number'        => array('Number', 'desc'),
                'customer_name' => array('Name/Legal Name', 'asc'),
                'issue_date'    => array('Date', 'desc'),
                'due_date'      => array('Due Date', 'asc'),
                'status'        => array('Status', 'asc'),
                'due_amount'    => array('Due', 'desc'),
                'gross_amount'  => array('Total', 'desc'),
                'related_estimate'  => array('Estimate', 'asc')
                ), $sf_data->getRaw('sort'), '@invoices');
            ?>
            <th class="noborder"></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($invoices as $i => $invoice): ?>
            <?php
              $id       = $invoice->getId();
              $parity   = ($i % 2) ? 'odd' : 'even';
              $closed   = ($invoice->getStatus() == Invoice::CLOSED);
            ?>
            <tr id="invoice-<?php echo $id ?>" class="<?php echo "$parity link invoice-$id" ?>">
              <td class="check"><input rel="item" type="checkbox" value="<?php echo $id ?>" name="ids[]"></td>
              <td><?php echo $invoice->getSeries()->getName() ?></td>
              <td><?php echo $invoice ?></td>
              <td class="<?php echo $invoice->getSentByEmail() ? 'sent' : null ?><?php echo $invoice->getRemesed() ? 'remesed' : null ?>"><?php echo $invoice->getCustomerName() ?> <br><span style="padding-left:10px;font-size:11px;font-style:italic;"><?php echo __('Notes').': '.substr($invoice->getNotes(),0,40) ?></span></td>
              <td><?php echo format_date($invoice->getIssueDate()) ?></td>
              <td><?php echo format_date($invoice->getDueDate()) ?></td>
              <td>
                <span class="status <?php echo ($stat = $invoice->getStatusString()) ?>">
                  <?php echo __($stat) ?>
                </span>
              </td>
              <td class="right"><?php if ($invoice->getDueAmount() != 0) echo format_currency($invoice->getDueAmount(), $currency) ?></td>
              <td class="right">
                <?php if ($invoice->getDraft()): ?>
                  <span class="draftAmount" title="<?php echo __('This amount is not reflected in the total') ?>"></span>
                <?php endif?>
                <?php echo format_currency($invoice->getGrossAmount(), $currency)  ?>
              </td>
              <td><?php
                        $rel = $invoice->getEstimate()->getId();
                        if(isset($rel))
                        {
                           echo link_to(__('Go to Estimate'),'@estimates_edit?id='.$rel);
                        }
                        else
                        {
                           echo __('No related Estimate');
                        }

               ?></td>
              <td class="action payments">
                <?php echo gButton(__("Payments"), "id=load-payments-for-$id type=button rel=payments:show class=payment action-clear {$invoice->getStatus()}") ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>

        <tfoot>
          <tr class="noborder">
            <td colspan="10" class="listing-options">
              <?php include_partial('batchActions'); ?>
            </td>
          </tr>
        </tfoot>

      </table>
    </form>

    <?php include_partial('global/pager', array('pager' => $pager, 'route' => '@invoices')) ?>
    
  <?php else: ?>
    <p><?php echo __('No results') ?></p>
  <?php endif ?>
  
</div>
