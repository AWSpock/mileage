<?php

class Reminder
{
    protected $id;
    protected $created;
    protected $updated;
    protected $name;
    protected $description;
    protected $due_months;
    protected $due_miles;
    protected $due_date;
    protected $due_odometer;

    public function __construct($rec = null)
    {
        $this->id = -1;
        if ($rec !== null) {
            $this->id = (array_key_exists("id", $rec) && $rec['id'] !== NULL) ? $rec['id'] : -1;
            $this->created = (array_key_exists("created", $rec) && $rec['created'] !== NULL) ? $rec['created'] : null;
            $this->updated = (array_key_exists("updated", $rec) && $rec['updated'] !== NULL) ? $rec['updated'] : null;
            $this->name = (array_key_exists("name", $rec) && $rec['name'] !== NULL) ? $rec['name'] : null;
            $this->description = (array_key_exists("description", $rec) && $rec['description'] !== NULL) ? $rec['description'] : null;
            $this->due_months = (array_key_exists("due_months", $rec) && $rec['due_months'] !== NULL && $rec['due_months'] !== '') ? $rec['due_months'] : null;
            $this->due_miles = (array_key_exists("due_miles", $rec) && $rec['due_miles'] !== NULL && $rec['due_miles'] !== '') ? $rec['due_miles'] : null;
            $this->due_date = (array_key_exists("due_date", $rec) && $rec['due_date'] !== NULL) ? $rec['due_date'] : null;
            $this->due_odometer = (array_key_exists("due_odometer", $rec) && $rec['due_odometer'] !== NULL && $rec['due_odometer'] !== "") ? $rec['due_odometer'] : null;
        }
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['reminder_id']) ? $post['reminder_id'] : -1;
        $rec1['name'] = $post['reminder_name'];
        $rec1['description'] = $post['reminder_description'];
        $rec1['due_months'] = $post['reminder_due_months'];
        $rec1['due_miles'] = $post['reminder_due_miles'];
        $rec1['due_date'] = $post['reminder_due_date'];
        $rec1['due_odometer'] = $post['reminder_due_odometer'];
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
        $rec1['due_months'] = $db['due_months'];
        $rec1['due_miles'] = $db['due_miles'];
        $rec1['due_date'] = $db['due_date'];
        $rec1['due_odometer'] = $db['due_odometer'];
        $new = new static($rec1);
        return $new;
    }

    public function set_due_date($val)
    {
        $this->due_date = $val;
    }
    public function set_due_odometer($val)
    {
        $this->due_odometer = $val;
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
    public function due_months()
    {
        return ($this->due_months === NULL) ? null : intval($this->due_months);
    }
    public function due_miles()
    {
        return ($this->due_miles === NULL) ? null : intval($this->due_miles);
    }
    public function due_date()
    {
        return $this->due_date;
    }
    public function due_odometer()
    {
        return ($this->due_odometer === NULL) ? null : intval($this->due_odometer);
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "updated" => $this->updated(),
            "name" => $this->name(),
            "description" => $this->description(),
            "due_months" => $this->due_months(),
            "due_miles" => $this->due_miles(),
            "due_date" => $this->due_date(),
            "due_odometer" => $this->due_odometer()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
