<?php
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($companyForm);
include_javascripts_for_form($companyForm);

$company = $companyForm->getObject();
?>
<div id="product-container" class="content">

  <h2><?php echo $title ?></h2>
  <form action="<?php echo url_for("companies/$action") ?>" method="post" <?php $companyForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="companies">
  <div id="saving-options" class="block" style="margin-top: 20px">
    <?php
    if ($company->getId()) {
      echo gButton_to(__('Delete'), "companies/delete?id=" . $company->getId(), array(
        'class' => 'action delete',
        'post' => true,
        'confirm' => __('Are you sure?'),
        ) , 'button=false')." ";
    }

    echo gButton(__('Save'), 'type=submit class=action primary save', 'button=true');
    ?>
  </div>
  <?php include_partial('common/globalErrors', array('form' => $companyForm)) ?>
  <?php
    echo $companyForm->renderHiddenFields();
  ?>
  <div id="company-data" class="global-data block">
  <h3><?php echo __('Company info') ?></h3>
  <ul>
    <div style="display:none">
        <?php echo $companyForm['logo']->renderRow(array('class' => error_class($companyForm['logo']))) ?>
    </div>
    <li>
      <span class="_75">
        <label class="light" for="<? echo $companyForm['name']->renderId()?>"><?php echo __('Company name') ?></label>
        <?php echo render_tag($companyForm['name'])?>
        </span>
      <span class="_25">
        <label class="light" for="<? echo $companyForm['identification']->renderId()?>"><?php echo __('Legal Id') ?></label>
        <?php echo render_tag($companyForm['identification'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['address']->renderId()?>"><?php echo __('Address') ?></label>
        <?php echo render_tag($companyForm['address'])?>
      </span>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['city']->renderId()?>"><?php echo __('City') ?></label>
        <?php echo render_tag($companyForm['city'])?>
      </span>
    </li>
    <li>
      <span class="_25">
        <label class="light" for="<? echo $companyForm['postalcode']->renderId()?>"><?php echo __('Postal code') ?></label>
        <?php echo render_tag($companyForm['postalcode'])?>
      </span>
      <span class="_25">
        <label class="light" for="<? echo $companyForm['state']->renderId()?>"><?php echo __('State') ?></label>
        <?php echo render_tag($companyForm['state'])?>
      </span>
        <span class="_25">
        <label class="light" for="<? echo $companyForm['country']->renderId()?>"><?php echo __('Country') ?></label>
        <?php echo render_tag($companyForm['country'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['phone']->renderId()?>"><?php echo __('Company phone') ?></label>
        <?php echo render_tag($companyForm['phone'])?>
      </span>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['fax']->renderId()?>"><?php echo __('Company fax') ?></label>
        <?php echo render_tag($companyForm['fax'])?>
      </span>
    </li>

    <li>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['email']->renderId()?>"><?php echo __('Company email') ?></label>
        <?php echo render_tag($companyForm['email'])?>
      </span>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['url']->renderId()?>"><?php echo __('Company Website') ?></label>
        <?php echo render_tag($companyForm['url'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['currency']->renderId()?>"><?php echo __('Currency') ?></label>
        <?php echo render_tag($companyForm['currency'])  ?>
        </span>
      <span class="_50">
        <label class="light" for="<? echo $companyForm['pdf_size']->renderId()?>"><?php echo __('Page size') ?></label>
        <?php echo render_tag($companyForm['pdf_size']) ?></span>
    </li>
  </ul>
</div>
  <div id="company-bank-data" class="global-data block">
    <h3><?php echo __('Bank details') ?></h3>
    <ul>
    <li>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity']->renderId()?>"><?php echo __('Financial Entity') ?></label>
        <?php echo render_tag($companyForm['financial_entity'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity_office']->renderId()?>"><?php echo __('Office') ?></label>
        <?php echo render_tag($companyForm['financial_entity_office']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity_control_digit']->renderId()?>"><?php echo __('Control digit') ?></label>
        <?php echo render_tag($companyForm['financial_entity_control_digit'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity_account']->renderId()?>"><?php echo __('Account') ?></label>
        <?php echo render_tag($companyForm['financial_entity_account']) ?></span>
      <span class="_50">
        <label for="<? echo $companyForm['sufix']->renderId()?>"><?php echo __('Sufix') ?></label>
        <?php echo render_tag($companyForm['sufix']) ?></span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity_bic']->renderId()?>"><?php echo __('BIC Code') ?></label>
        <?php echo render_tag($companyForm['financial_entity_bic'])  ?>
        </span>
      <span class="_50">
        <label for="<? echo $companyForm['financial_entity_iban']->renderId()?>"><?php echo __('IBAN') ?></label>
        <?php echo render_tag($companyForm['financial_entity_iban']) ?></span>
    </li>
  </ul>
</div>
   <div class="global-data block">
    <h3><?php echo __('Other info') ?></h3>
    <ul>
    <li>
      <span class="_100">
        <label for="<? echo $companyForm['mercantil_registry']->renderId()?>"><?php echo __('Mercantil Registry') ?></label>
        <?php echo render_tag($companyForm['mercantil_registry'])  ?>
        </span>
    </li>
    <li>
      <span class="_100">
        <label for="<? echo $companyForm['fiscality']->renderId()?>"><?php echo __('Fiscality Enabled') ?></label>
        <?php echo render_tag($companyForm['fiscality'])  ?>
        </span>
    </li>
  </ul>
  </div>
  <div id="company-users-data" class="global-data block">
    <h3><?php echo __('Assigned Users') ?></h3>
    <ul>
    <li>
      <span class="_50"><?php echo render_tag($companyForm['company_user_list'])?></span>
    </li>
  </ul>
</div>
  <div id="saving-options" class="block" style="margin-top: 20px">
    <?php
    if ($company->getId()) {
      echo gButton_to(__('Delete'), "companies/delete?id=" . $company->getId(), array(
        'class' => 'action delete',
        'post' => true,
        'confirm' => __('Are you sure?'),
        ) , 'button=false')." ";
    }

    echo gButton(__('Save'), 'type=submit class=action primary save', 'button=true');
    ?>
  </div>
  </form>
</div>
    <?php
echo javascript_tag("
  var validateDC = function(){
      var cd = $('#".$companyForm['financial_entity_control_digit']->renderId()."');
      var financial_entity = $('#".$companyForm['financial_entity']->renderId()."');
      var financial_entity_office = $('#".$companyForm['financial_entity_office']->renderId()."');
      var financial_entity_account = $('#".$companyForm['financial_entity_account']->renderId()."');

      if (financial_entity.val() == '' || financial_entity_office.val() == '' || cd.val() == '' || financial_entity_account.val() == '')
          return;

      correctcd = calcularDC(financial_entity.val(), financial_entity_office.val(), financial_entity_account.val())
          if (correctcd != cd.val()){
                alert('". __('Wrong Control Digit')."');
              }
          else {
            $('#".$companyForm['financial_entity_iban']->renderId()."').val(calcIBANforSpain(financial_entity.val(), financial_entity_office.val(), cd.val(), financial_entity_account.val()));
          }
    }
    var cd = $('#".$companyForm['financial_entity_control_digit']->renderId()."');
    var financial_entity = $('#".$companyForm['financial_entity']->renderId()."');
    var financial_entity_office = $('#".$companyForm['financial_entity_office']->renderId()."');
    var financial_entity_account = $('#".$companyForm['financial_entity_account']->renderId()."');
    cd.change(validateDC);
    financial_entity.change(validateDC);
    financial_entity_office.change(validateDC);
    financial_entity_account.change(validateDC);
    "); ?>
<?php
echo javascript_tag(" $('#company-data input[type=text], #company-data textarea').SiwappFormTips();") // See invoice.js
?>
