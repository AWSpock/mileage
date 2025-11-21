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
    protected $station;
    protected $partial;
    protected $missed;

    protected $mpg;
    protected $days;
    protected $miles;

    public function __construct($rec = null)
    {
        $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
        $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
        $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
        $this->date = (array_key_exists("date", $rec) && $rec['date'] !== NULL) ? $rec['date'] : null;
        $this->odometer = (array_key_exists("odometer", $rec) && $rec['odometer'] !== NULL) ? intval($rec['odometer']) : null;
        $this->gallon = (array_key_exists("gallon", $rec) && $rec['gallon'] !== NULL) ? $rec['gallon'] : null;
        $this->ppg = (array_key_exists("ppg", $rec) && $rec['ppg'] !== NULL) ? $rec['ppg'] : null;
        $this->station = (array_key_exists("station", $rec) && $rec['station'] !== NULL) ? $rec['station'] : null;
        $this->partial = (array_key_exists("partial", $rec) && $rec['partial'] !== NULL) ? $rec['partial'] : null;
        $this->missed = (array_key_exists("missed", $rec) && $rec['missed'] !== NULL) ? $rec['missed'] : null;
        $this->mpg = (array_key_exists("mpg", $rec) && $rec['mpg'] !== NULL) ? $rec['mpg'] : null;
        $this->days = (array_key_exists("days", $rec) && $rec['days'] !== NULL) ? $rec['days'] : null;
        $this->miles = (array_key_exists("miles", $rec) && $rec['miles'] !== NULL) ? $rec['miles'] : null;
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
        $rec1['mpg'] = $db['mpg'];


        if ($db['days'] === "NULL") {
            $rec1['days'] = null;
        } else {
            if (empty($db['days'])) {
                $rec1['days'] = "00";
            } else {
                $rec1['days'] = intval($db['days']);
            }
        }
        // $rec1['days'] = $db['days'] == "NULL" ? NULL : intval($db['days']);

        $rec1['miles'] = $db['miles'];
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
    public function date()
    {
        return $this->date;
    }
    public function odometer()
    {
        return ($this->odometer === NULL) ? null : intval($this->odometer);
    }
    public function gallon()
    {
        return ($this->gallon === NULL) ? null : floatval($this->gallon);
    }
    public function ppg()
    {
        return ($this->ppg === NULL) ? null : floatval($this->ppg);
    }
    public function price()
    {
        return floatval($this->ppg * $this->gallon);
    }
    public function station()
    {
        return $this->station;
    }
    public function partial()
    {
        return boolval($this->partial);
    }
    public function missed()
    {
        return boolval($this->missed);
    }

    public function mpg()
    {
        return ($this->mpg === NULL) ? null : floatval($this->mpg);
    }
    public function set_mpg($val)
    {
        $this->mpg = $val;
    }
    public function days()
    {
        return ($this->days === NULL) ? null : intval($this->days);
    }
    public function set_days($val)
    {
        $this->days = $val;
    }
    public function miles()
    {
        return ($this->miles === NULL) ? null : intval($this->miles);
    }
    public function set_miles($val)
    {
        $this->miles = $val;
    }


    // public function milesperday()
    // {
    //     if(is_null($this->miles) || is_null($this->days))
    //         return null;
    //     if($this->days() == 0)
    //         return
    //     return is_null($this->miles) ||  ? null : intval($this->miles);
    // }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "date" => $this->date(),
            "odometer" => $this->odometer(),
            "gallon" => $this->gallon(),
            "ppg" => $this->ppg(),
            "price" => $this->price(),
            "station" => $this->station(),
            "partial" => $this->partial(),
            "missed" => $this->missed(),
            "mpg" => $this->mpg(),
            "days" => $this->days(),
            "miles" => $this->miles()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
