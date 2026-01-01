<?php

class Vehicle
{
    protected $id;
    protected $created;
    protected $updated;
    protected $name;
    protected $make;
    protected $model;
    protected $year;
    protected $color;
    protected $tank_capacity;
    protected $purchase_date;
    protected $sell_date;
    protected $purchase_price;
    protected $sell_price;
    protected $purchase_odometer;
    protected $sell_odometer;
    protected $favorite;
    protected $role;

    protected $bill_types;

    public function __construct($rec = null)
    {
        $this->id = -1;
        if ($rec !== null) {
            $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
            $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
            $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
            $this->name = (array_key_exists("name", $rec) && $rec['name'] !== NULL) ? $rec['name'] : null;
            $this->make = (array_key_exists("make", $rec) && $rec['make'] !== NULL) ? $rec['make'] : null;
            $this->model = (array_key_exists("model", $rec) && $rec['model'] !== NULL) ? $rec['model'] : null;
            $this->year = (array_key_exists("year", $rec) && $rec['year'] !== NULL) ? $rec['year'] : null;
            $this->color = (array_key_exists("color", $rec) && $rec['color'] !== NULL) ? $rec['color'] : null;
            $this->tank_capacity = (array_key_exists("tank_capacity", $rec) && $rec['tank_capacity'] !== NULL) ? $rec['tank_capacity'] : null;
            $this->purchase_date = (array_key_exists("purchase_date", $rec) && $rec['purchase_date'] !== NULL) ? $rec['purchase_date'] : null;
            $this->sell_date = (array_key_exists("sell_date", $rec) && $rec['sell_date'] !== NULL) ? $rec['sell_date'] : null;
            $this->purchase_price = (array_key_exists("purchase_price", $rec) && $rec['purchase_price'] !== NULL) ? $rec['purchase_price'] : null;
            $this->sell_price = (array_key_exists("sell_price", $rec) && $rec['sell_price'] !== NULL) ? $rec['sell_price'] : null;
            $this->purchase_odometer = (array_key_exists("purchase_odometer", $rec) && $rec['purchase_odometer'] !== NULL) ? $rec['purchase_odometer'] : null;
            $this->sell_odometer = (array_key_exists("sell_odometer", $rec) && $rec['sell_odometer'] !== NULL) ? $rec['sell_odometer'] : null;
            $this->favorite = (array_key_exists("favorite", $rec) && $rec['favorite'] !== NULL) ? $rec['favorite'] : null;
            $this->role = (array_key_exists("role", $rec) && $rec['role'] !== NULL) ? $rec['role'] : null;
        }
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['vehicle_id']) ? $post['vehicle_id'] : -1;
        $rec1['name'] = $post['vehicle_name'];
        $rec1['make'] = $post['vehicle_make'];
        $rec1['model'] = $post['vehicle_model'];
        $rec1['year'] = $post['vehicle_year'];
        $rec1['color'] = $post['vehicle_color'];
        $rec1['tank_capacity'] = $post['vehicle_tank_capacity'];
        $rec1['purchase_date'] = $post['vehicle_purchase_date'];
        $rec1['sell_date'] = !empty($post['vehicle_sell_date']) ? $post['vehicle_sell_date'] : null;
        $rec1['purchase_price'] = $post['vehicle_purchase_price'];
        $rec1['sell_price'] = !empty($post['vehicle_sell_price']) ? $post['vehicle_sell_price'] : null;
        $rec1['purchase_odometer'] = $post['vehicle_purchase_odometer'];
        $rec1['sell_odometer'] = !empty($post['vehicle_sell_odometer']) ? $post['vehicle_sell_odometer'] : null;
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['updated'] = $db['updated'];
        $rec1['name'] = $db['name'];
        $rec1['make'] = $db['make'];
        $rec1['model'] = $db['model'];
        $rec1['year'] = $db['year'];
        $rec1['color'] = $db['color'];
        $rec1['tank_capacity'] = $db['tank_capacity'];
        $rec1['purchase_date'] = $db['purchase_date'];
        $rec1['sell_date'] = $db['sell_date'];
        $rec1['purchase_price'] = $db['purchase_price'];
        $rec1['sell_price'] = $db['sell_price'];
        $rec1['purchase_odometer'] = $db['purchase_odometer'];
        $rec1['sell_odometer'] = $db['sell_odometer'];
        $rec1['favorite'] = $db['favorite'];
        $rec1['role'] = $db['role'];
        $new = new static($rec1);
        return $new;
    }

    public function id()
    {
        return intval($this->id);
    }
    public function created()
    {
        return $this->created;
    }
    public function updated()
    {
        return $this->updated;
    }
    public function name()
    {
        return $this->name;
    }
    public function make()
    {
        return $this->make;
    }
    public function model()
    {
        return $this->model;
    }
    public function year()
    {
        return ($this->year === NULL) ? null : intval($this->year);
    }
    public function color()
    {
        return $this->color;
    }
    public function tank_capacity()
    {
        return ($this->tank_capacity === NULL) ? null : floatval($this->tank_capacity);
    }
    public function purchase_date()
    {
        return $this->purchase_date;
    }
    public function sell_date()
    {
        return $this->sell_date;
    }
    public function purchase_price()
    {
        return ($this->purchase_price === NULL) ? null : floatval($this->purchase_price);
    }
    public function sell_price()
    {
        return ($this->sell_price === NULL) ? null : floatval($this->sell_price);
    }
    public function purchase_odometer()
    {
        return ($this->purchase_odometer === NULL) ? null : intval($this->purchase_odometer);
    }
    public function sell_odometer()
    {
        return ($this->sell_odometer === NULL) ? null : intval($this->sell_odometer);
    }
    public function favorite()
    {
        return $this->favorite;
    }
    public function role()
    {
        return $this->role;
    }
    public function isOwner()
    {
        return boolval($this->role == "Owner");
    }
    public function isManager()
    {
        return boolval($this->role == "Manager");
    }
    public function isViewer()
    {
        return boolval($this->role == "Viewer");
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "name" => $this->name(),
            "make" => $this->make(),
            "model" => $this->model(),
            "year" => $this->year(),
            "color" => $this->color(),
            "tank_capacity" => $this->tank_capacity(),
            "purchase_date" => $this->purchase_date(),
            "sell_date" => $this->sell_date(),
            "purchase_price" => $this->purchase_price(),
            "sell_price" => $this->sell_price(),
            "purchase_odometer" => $this->purchase_odometer(),
            "sell_odometer" => $this->sell_odometer(),
            "favorite" => $this->favorite()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }

    //

    // public function bill_types()
    // {
    //     return $this->bill_types;
    // }
    // public function store_bill_type(BillType $rec)
    // {
    //     if ($this->bill_types === null)
    //         $this->bill_types = [];
    //     $this->bill_types[$rec->id()] = $rec;
    // }
    // public function store_bill_types(array $recs)
    // {
    //     $this->bill_types = [];

    //     foreach ($recs as $rec) {
    //         if (!$rec instanceof BillType)
    //             throw new InvalidArgumentException("Array must contain only instances of BillType");
    //         $this->bill_types[$rec->id()] = $rec;
    //     }
    // }
}
