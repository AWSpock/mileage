<?php

class Fillup
{
    protected $id;
    protected $created;
    protected $updated;
    protected $date;
    protected $odometer;
    protected $gallon;
    protected $ppg;
    protected $price;
    protected $station;
    protected $partial;
    protected $missed;

    public function __construct($rec = null)
    {
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->date = !empty($rec['date']) ? $rec['date'] : null;
        $this->odometer = !empty($rec['odometer']) ? intval($rec['odometer']) : null;
        $this->gallon = !empty($rec['gallon']) ? $rec['gallon'] : null;
        $this->ppg = !empty($rec['ppg']) ? $rec['ppg'] : null;
        $this->price = !(empty($rec['ppg']) && empty($rec['gallon'])) ? $rec['ppg'] * $rec['gallon'] : null;
        $this->station = !empty($rec['station']) ? $rec['station'] : null;
        $this->partial = !empty($rec['partial']) ? $rec['partial'] : null;
        $this->missed = !empty($rec['missed']) ? $rec['missed'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['fillup_id']) ? $post['fillup_id'] : -1;
        $rec1['date'] = $post['fillup_date'];
        $rec1['odometer'] = $post['fillup_odometer'];
        $rec1['gallon'] = $post['fillup_gallon'];
        $rec1['ppg'] = $post['fillup_ppg'];
        $rec1['station'] = $post['fillup_station'];
        $rec1['partial'] = $post['fillup_partial'];
        $rec1['missed'] = $post['fillup_missed'];
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
        $rec1['gallon'] = $db['gallon'];
        $rec1['ppg'] = $db['ppg'];
        $rec1['station'] = $db['station'];
        $rec1['partial'] = $db['partial'];
        $rec1['missed'] = $db['missed'];
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
    public function gallon()
    {
        return floatval($this->gallon);
    }
    public function ppg()
    {
        return floatval($this->ppg);
    }
    public function price()
    {
        return floatval($this->price);
    }
    public function station()
    {
        return $this->station;
    }
    public function partial()
    {
        return (bool)$this->partial;
    }
    public function missed()
    {
        return (bool)$this->missed;
    }

    public function toString($pretty = false)
    {
        if ($pretty === true)
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($this));
    }
}
