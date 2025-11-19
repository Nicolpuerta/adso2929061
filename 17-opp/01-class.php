<?php
$title = '01- Class';
$description = 'Blueprint for creating objects with shared properties and behaviors';

include_once 'template/header.php';
echo "<section>";

class Vehicle
{
  # Attributes (Properties/characteristics)
  public $brand;
  public $refer;
  public $model;
  public $color;

  #methods (behaviors/actions)
  public function setAttributes($b, $r, $m, $c)
  {
    $this->brand = $b;
    $this->refer = $r;
    $this->model = $m;
    $this->color = $c;
  }

  public function getAttributes()
  {
    return "<ul>
                  <li><strong>Brand:  </strong> $this->brand </li>
                  <li><strong>Refer:  </strong> $this->refer </li>
                  <li><strong>Model:  </strong> $this->model </li>
                  <li><strong>Color:  </strong> $this->color </li>
              </ul>";
  }
}
# intance an object
$vh1 = new Vehicle;
$vh1->setAttributes('Volkswagen', 'Gold', 2020, 'Black');
echo $vh1->getAttributes();

$vh2 = new Vehicle;
$vh2->setAttributes('Toyota', 'Hilux', 2018, 'Green');
$vh2->color = 'Blue';
echo $vh2->getAttributes();

$vh3 = new Vehicle;
$vh3->brand = 'Mazda';
$vh3->refer = 'CX30 ';
$vh3->model = 2024;
$vh3->color = 'Gray';
echo $vh->getAttributes();

include_once 'template/footer.php';
