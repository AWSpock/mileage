<?php

class Trip
{
    protected $id;
    protected $created;
    protected $updated;
    protected $name;
    protected $description;

    protected $trip_checkpoints;

    public function __construct($rec = null)
    {
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->name = !empty($rec['name']) ? $rec['name'] : null;
        $this->description = !empty($rec['description']) ? $rec['description'] : null;
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

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "name" => $this->name(),
            "description" => $this->description()
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
