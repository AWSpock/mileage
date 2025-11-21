<?php

class TripCheckpoint
{
    protected $id;
    protected $created;
    protected $updated;
    protected $date;
    protected $odometer;
    protected $description;

    public function __construct($rec = null)
    {
        $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
        $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
        $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
        $this->date = (array_key_exists("date", $rec) && $rec['date'] !== NULL) ? $rec['date'] : null;
        $this->odometer = (array_key_exists("odometer", $rec) && $rec['odometer'] !== NULL) ? intval($rec['odometer']) : null;
        $this->description = (array_key_exists("description", $rec) && $rec['description'] !== NULL) ? $rec['description'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['trip_checkpoint_id']) ? $post['trip_checkpoint_id'] : -1;
        $rec1['date'] = $post['trip_checkpoint_date'];
        $rec1['odometer'] = $post['trip_checkpoint_odometer'];
        $rec1['description'] = $post['trip_checkpoint_description'];
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
        $rec1['description'] = $db['description'];
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
            "date" => $this->date(),
            "odometer" => $this->odometer(),
            "description" => $this->description()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
