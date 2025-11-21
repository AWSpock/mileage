<?php

class Trip
{
    protected $id;
    protected $created;
    protected $updated;
    protected $name;
    protected $description;

    protected $start_date;
    protected $end_date;
    protected $start_odometer;
    protected $end_odometer;
    protected $miles;
    protected $days;

    protected $trip_checkpoints;

    public function __construct($rec = null)
    {
        $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
        $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
        $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
        $this->name = (array_key_exists("name", $rec) && $rec['name'] !== NULL) ? $rec['name'] : null;
        $this->description = (array_key_exists("description", $rec) && $rec['description'] !== NULL) ? $rec['description'] : null;
        $this->start_date = (array_key_exists("start_date", $rec) && $rec['start_date'] !== NULL) ? $rec['start_date'] : null;
        $this->end_date = (array_key_exists("end_date", $rec) && $rec['end_date'] !== NULL) ? $rec['end_date'] : null;
        $this->start_odometer = (array_key_exists("start_odometer", $rec) && $rec['start_odometer'] !== NULL) ? $rec['start_odometer'] : null;
        $this->end_odometer = (array_key_exists("end_odometer", $rec) && $rec['end_odometer'] !== NULL) ? $rec['end_odometer'] : null;
        $this->miles = (array_key_exists("miles", $rec) && $rec['miles'] !== NULL) ? $rec['miles'] : null;
        $this->days = (array_key_exists("days", $rec) && $rec['days'] !== NULL) ? $rec['days'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['trip_id']) ? $post['trip_id'] : -1;
        $rec1['name'] = $post['trip_name'];
        $rec1['description'] = $post['trip_description'];
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['updated'] = $db['updated'];
        $rec1['name'] = $db['name'];
        $rec1['description'] = $db['description'];
        $rec1['start_date'] = $db['start_date'];
        $rec1['end_date'] = $db['end_date'];
        $rec1['start_odometer'] = $db['start_odometer'];
        $rec1['end_odometer'] = $db['end_odometer'];
        $rec1['days'] = $db['days'];
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
    public function name()
    {
        return $this->name;
    }
    public function description()
    {
        return $this->description;
    }

    public function start_date()
    {
        return $this->start_date;
    }
    public function end_date()
    {
        return $this->end_date;
    }
    public function start_odometer()
    {
        return ($this->start_odometer === NULL) ? null : intval($this->start_odometer);
    }
    public function end_odometer()
    {
        return ($this->end_odometer === NULL) ? null : intval($this->end_odometer);
    }
    public function miles()
    {
        return ($this->miles === NULL) ? null : intval($this->miles);
    }
    public function days()
    {
        return ($this->days === NULL) ? null : intval($this->days);
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "name" => $this->name(),
            "description" => $this->description(),
            "start_date" => $this->start_date(),
            "start_odometer" => $this->start_odometer(),
            "end_date" => $this->end_date(),
            "end_odometer" => $this->end_odometer(),
            "miles" => $this->miles(),
            "days" => $this->days()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }

    //

    public function trip_checkpoints()
    {
        return $this->trip_checkpoints;
    }
    public function store_trip_checkpoint(TripCheckpoint $rec)
    {
        if ($this->trip_checkpoints === null)
            $this->trip_checkpoints = [];
        $this->trip_checkpoints[$rec->id()] = $rec;
    }
    public function store_trip_checkpoints(array $recs)
    {
        $this->trip_checkpoints = [];

        foreach ($recs as $rec) {
            if (!$rec instanceof TripCheckpoint)
                throw new InvalidArgumentException("Array must contain only instances of TripCheckpoint");
            $this->trip_checkpoints[$rec->id()] = $rec;
        }
    }
}
