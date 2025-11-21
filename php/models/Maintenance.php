<?php

class Maintenance
{
    protected $id;
    protected $created;
    protected $updated;
    protected $date;
    protected $odometer;
    protected $price;
    protected $description;
    protected $garage;

    public function __construct($rec = null)
    {
        $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
        $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
        $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
        $this->date = (array_key_exists("date", $rec) && $rec['date'] !== NULL) ? $rec['date'] : null;
        $this->odometer = (array_key_exists("odometer", $rec) && $rec['odometer'] !== NULL) ? intval($rec['odometer']) : null;
        $this->price = (array_key_exists("price", $rec) && $rec['price'] !== NULL) ? $rec['price'] : null;
        $this->description = (array_key_exists("description", $rec) && $rec['description'] !== NULL) ? $rec['description'] : null;
        $this->garage = (array_key_exists("garage", $rec) && $rec['garage'] !== NULL) ? $rec['garage'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['maintenance_id']) ? $post['maintenance_id'] : -1;
        $rec1['date'] = $post['maintenance_date'];
        $rec1['odometer'] = $post['maintenance_odometer'];
        $rec1['price'] = $post['maintenance_price'];
        $rec1['description'] = $post['maintenance_description'];
        $rec1['garage'] = $post['maintenance_garage'];
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['updated'] = $db['updated'];
        $rec1['date'] = $db['date'];
        $rec1['odometer'] = $db['odometer'];
        $rec1['price'] = $db['price'];
        $rec1['description'] = $db['description'];
        $rec1['garage'] = $db['garage'];
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
    public function date()
    {
        return $this->date;
    }
    public function odometer()
    {
        return is_null($this->odometer) ? null : intval($this->odometer);
    }
    public function price()
    {
        return is_null($this->price) ? null : floatval($this->price);
    }
    public function description()
    {
        return $this->description;
    }
    public function garage()
    {
        return $this->garage;
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "date" => $this->date(),
            "odometer" => $this->odometer(),
            "price" => $this->price(),
            "description" => $this->description(),
            "garage" => $this->garage()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
