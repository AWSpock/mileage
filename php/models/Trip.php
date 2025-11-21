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
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->name = !empty($rec['name']) ? $rec['name'] : null;
        $this->description = !empty($rec['description']) ? $rec['description'] : null;
        $this->start_date = !empty($rec['start_date']) ? $rec['start_date'] : null;
        $this->end_date = !empty($rec['end_date']) ? $rec['end_date'] : null;
        $this->start_odometer = !empty($rec['start_odometer']) ? $rec['start_odometer'] : null;
        $this->end_odometer = !empty($rec['end_odometer']) ? $rec['end_odometer'] : null;
        $this->miles = !empty($rec['miles']) ? $rec['miles'] : null;
        $this->days = !empty($rec['days']) ? intval($rec['days']) : null;
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
        $rec1['days'] = intval($db['days']);
        $rec1['miles'] = $db['miles'];
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
        return $this->start_odometer;
    }
    public function end_odometer()
    {
        return $this->end_odometer;
    }
    public function miles()
    {
        return is_null($this->miles) ? null : intval($this->miles);
    }
    public function days()
    {
        return is_null($this->days) ? null : intval($this->days);
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
