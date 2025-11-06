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
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->date = !empty($rec['date']) ? $rec['date'] : null;
        $this->odometer = !empty($rec['odometer']) ? intval($rec['odometer']) : null;
        $this->price = !empty($rec['price']) ? $rec['price'] : null;
        $this->description = !empty($rec['description']) ? $rec['description'] : null;
        $this->garage = !empty($rec['garage']) ? $rec['garage'] : null;
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
        return intval($this->odometer);
    }
    public function price()
    {
        return floatval($this->price);
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
        if ($pretty === true)
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($this));
    }
}
