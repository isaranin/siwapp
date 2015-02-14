<?php

class ProductQuery extends Doctrine_Query
{
  public $quantity_col = "
             FORMAT(
                    SUM(
                        IF(
                           inv.draft=1 
                           OR inv.type='RecurringInvoice' 
                           OR inv.type='Expense' 
                           OR i.quantity IS NULL,
                           0, 
                           i.quantity
                          ), 
                        0
                       ),
                    0
                   ) AS quantity";

    public $sold_col = "
      SUM(
          IF(
             inv.draft = 1
             OR inv.type = 'RecurringInvoice'
             OR inv.type='Expense' 
             OR i.quantity IS NULL
             OR i.unitary_cost IS NULL,
             0, 
             (case when i.discount <> 0.00 then (1 - i.discount * 0.01) else 1.00 end) * i.quantity * i.unitary_cost
            )
         ) AS sold";


  public static function create($conn = null, $class = null)
  {
    $q = new ProductQuery($conn);

      
    $q->addSelect('p.id, p.reference, p.description, p.price')
      ->addSelect('pc.name AS category')
      ->addSelect($q->quantity_col)
      ->addSelect($q->sold_col)
      ->from("Product p, p.Items i, i.Common inv, p.ProductCategory pc")
      ->Where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))
      ->orderBy('p.reference asc')
      ->groupBy('p.id');
    //    echo $q->getSqlQuery();
    return $q;
  }

  public function getClone()
  {
    $other = clone($this);
    return $other;
  }

  public function search($search = null)
  {
    if($search)
    {
      if(isset($search['query']))  $this->textSearch($search['query']);
      if(isset($search['category']))  $this->categorySearch($search['category']);
      if(isset($search['from'])) $this->fromDate($search['from']);
      if(isset($search['to'])) $this->toDate($search['to']);
      //TODO MCY adding other query
    }
    return $this;
  }
  
  public function textSearch($text)
  {
    $text = trim($text);
    if($text)
    {
      //TODO MCY check if we could use a parameter instead
      $this
        ->addWhere("(p.reference LIKE '%$text%'".
                   " OR p.description LIKE '%$text%') ");
                   

    }
    return $this;
  }

  public function categorySearch($category)
  {
    if($category)
    {
      //TODO MCY check if we could use a parameter instead
      $this
        ->addWhere("p.category_id = $category ");

    }
    return $this;
  }
  
  public function stockAlarmsSearch($search = null)
  {
    $this
      ->addWhere("stock <= min_stock_level");
    
    if($search)
    {
      if(isset($search['query']))  $this->textSearch($search['query']);
      if(isset($search['category']))  $this->categorySearch($search['category']);
      if(isset($search['from'])) $this->fromDate($search['from']);
      if(isset($search['to'])) $this->toDate($search['to']);
      //TODO MCY adding other query
    }
    return $this;
  }

  public function total($field)
  {
    $other = clone($this);
    $other->addSelect("'t' AS true_column")->groupBy('true_column');
    switch($field)
    {
      case 'quantity':
        return $other->fetchOne() ? $other->fetchOne()->getQuantity():0;
        break;
      case 'sold':
        return $other->fetchOne() ? $other->fetchOne()->getSold():0;
        break;
    }


    return $other->fetchOne() ? $other->fetchOne()->getTotal():0;
  }
    

  public function fromDate($date = null)
  {
    if (!($date = $this->filterDate($date)))
    {
      return $this;
    }
    else
    {
      return $this->andWhere('inv.issue_date >= ?', sfDate::getInstance($date)->to_database());
    }
  }
  

  public function toDate($date = null)
  {
    if (!($date = $this->filterDate($date)))
    {
      return $this;
    }
    else
    {
      return $this->andWhere('inv.issue_date < ?', sfDate::getInstance($date)->addDay(1)->to_database());
    }
  }
  /**
   * Internal method to deduce a correct or null date value.
   * @param mixed date; if it is an array it must have the 'year', 'month' and 'day' keys.
   * @return mixed date string or whatever passed from outside if not "strictly invalid".
   * @author Carlos Escribano <carlos@markhaus.com>
   */
  protected function filterDate($date)
  {
    switch (true)
    {
      case (!$date || !strlen(trim(implode('', (array) $date)))):
      case (is_array($date) && (!isset($date['year']) || !isset($date['month']) || !isset($date['day']))):
        // $date is null or is an array with empty or zero string elements
        // or one of its components is not set (year, month, day)
        return null;
      case (is_array($date)):
        // is an array and is not bad formed
        return $date['year'].'-'.$date['month'].'-'.$date['day'];
      default:
        // is not an array
        return $date;
    }
  }
    
  
}
