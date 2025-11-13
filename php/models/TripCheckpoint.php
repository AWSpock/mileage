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
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->updated = !empty($rec['updated']) ? $rec['updated'] : null;
        $this->date = !empty($rec['date']) ? $rec['date'] : null;
        $this->odometer = !empty($rec['odometer']) ? intval($rec['odometer']) : null;
        $this->description = !empty($rec['description']) ? $rec['description'] : null;
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
    public function description()
    {
        return floatval($this->description);
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
