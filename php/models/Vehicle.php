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
    // protected $favorite;
    // protected $role;

    protected $bill_types;

    public function __construct($rec = null)
    {
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->name = !empty($rec['name']) ? $rec['name'] : null;
        $this->make = !empty($rec['make']) ? $rec['make'] : null;
        $this->model = !empty($rec['model']) ? $rec['model'] : null;
        $this->year = !empty($rec['year']) ? $rec['year'] : null;
        $this->color = !empty($rec['color']) ? $rec['color'] : null;
        $this->tank_capacity = !empty($rec['tank_capacity']) ? $rec['tank_capacity'] : null;
        $this->purchase_date = !empty($rec['purchase_date']) ? $rec['purchase_date'] : null;
        $this->sell_date = !empty($rec['sell_date']) ? $rec['sell_date'] : null;
        $this->purchase_price = !empty($rec['purchase_price']) ? $rec['purchase_price'] : null;
        $this->sell_price = !empty($rec['sell_price']) ? $rec['sell_price'] : null;
        $this->purchase_odometer = !empty($rec['purchase_odometer']) ? $rec['purchase_odometer'] : null;
        $this->sell_odometer = !empty($rec['sell_odometer']) ? $rec['sell_odometer'] : null;
        // $this->favorite = !empty($rec['favorite']) ? $rec['favorite'] : null;
        // $this->role = !empty($rec['role']) ? $rec['role'] : null;
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
        $rec1['sell_date'] = $post['vehicle_sell_date'];
        $rec1['purchase_price'] = $post['vehicle_purchase_price'];
        $rec1['sell_price'] = $post['vehicle_sell_price'];
        $rec1['purchase_odometer'] = $post['vehicle_purchase_odometer'];
        $rec1['sell_odometer'] = $post['vehicle_sell_odometer'];
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
        // $rec1['favorite'] = $db['favorite'];
        // $rec1['role'] = $db['role'];
        $new = new static($rec1);
        return $new;
    }

    public function id()
    {
        return $this->id;
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
        return $this->year;
    }
    public function color()
    {
        return $this->color;
    }
    public function tank_capacity()
    {
        return $this->tank_capacity;
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
        return $this->purchase_price;
    }
    public function sell_price()
    {
        return $this->sell_price;
    }
    public function purchase_odometer()
    {
        return $this->purchase_odometer;
    }
    public function sell_odometer()
    {
        return $this->sell_odometer;
    }
    // public function favorite()
    // {
    //     return $this->favorite;
    // }
    // public function role()
    // {
    //     return $this->role;
    // }
    // public function isOwner()
    // {
    //     return $this->role == "Owner";
    // }
    // public function isManager()
    // {
    //     return $this->role == "Manager";
    // }
    // public function isViewer()
    // {
    //     return $this->role == "Viewer";
    // }

    public function toString($pretty = false)
    {
        if ($pretty === true)
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($this));
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
