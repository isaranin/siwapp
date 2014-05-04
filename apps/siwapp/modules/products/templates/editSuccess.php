<?php
use_helper('JavascriptBase', 'jQuery');
include_stylesheets_for_form($productForm);
include_javascripts_for_form($productForm);

$product = $productForm->getObject();
?>
<div id="product-container" class="content">

  <h2><?php echo $title ?></h2>
  <form action="<?php echo url_for("products/$action") ?>" method="post" <?php $productForm->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="product">
  <div id="saving-options" class="block" style="margin-top: 20px">
    <?php
    if ($product->getId()) {
      echo gButton_to(__('Delete'), "products/delete?id=" . $product->getId(), array(
        'class' => 'action delete',
        'post' => true,
        'confirm' => __('Are you sure?'),
        ) , 'button=false')." ";
    }
    
    echo gButton(__('Save'), 'type=submit class=action primary save', 'button=true');
    ?>
  </div>

  <?php include_partial('common/globalErrors', array('form' => $productForm)) ?>
  <?php
    echo $productForm->renderHiddenFields();
  ?>
  <div id="product-data" class="global-data block">
  <h3><?php echo __('Product info') ?></h3>
  <ul>
    <li>
      <span class="_50">
        <label for="<? echo $productForm['reference']->renderId()?>"><?php echo __('Reference') ?></label>
        <?php echo render_tag($productForm['reference'])?>
      </span>
      <span class="_25">
        <label for="<? echo $productForm['stock']->renderId()?>"><?php echo __('Stock') ?></label>      
        <?php echo render_tag($productForm['stock'])?>
      </span>
      <span class="_25">
        <label for="<? echo $productForm['min_stock_level']->renderId()?>"><?php echo __('Min stock level') ?></label>
        <?php echo render_tag($productForm['min_stock_level'])?>
      </span>
    </li>
    <li>
      <span class="_50">
        <label for="<? echo $productForm['category']->renderId()?>"><?php echo __('Category') ?></label>
        <?php echo render_tag($productForm['category_id'])?>
      </span> 
      <span class="_25">
        <label for="<? echo $productForm['price']->renderId()?>"><?php echo __('Price') ?></label>
        <?php echo render_tag($productForm['price'])?>
      </span>
      <span class="_25">
        <label for="<? echo $productForm['tax_id']->renderId()?>"><?php echo __('Tax') ?></label>
        <?php echo render_tag($productForm['tax_id'])?>
      </span>
    </li>
    <li>
      <span class="_75">
        <label for="<? echo $productForm['description']->renderId()?>"><?php echo __('Description') ?></label>
        <?php echo render_tag($productForm['description'])?>
      </span>     
    </li>
  </ul>
</div>
  <div id="saving-options" class="block" style="margin-top: 20px">
    <?php
    if ($product->getId()) {
      echo gButton_to(__('Delete'), "products/delete?id=" . $product->getId(), array(
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
  //echo javascript_tag(" $('#product-data input[type=text], #product-data textarea').SiwappFormTips();") // See invoice.js
?>
