<?php

class TripTag
{
    protected $id;
    protected $created;
    protected $tag;

    public function __construct($rec = null)
    {
        $this->id = !empty($rec['id']) ? $rec['id'] : -1;
        $this->created = !empty($rec['created']) ? $rec['created'] : null;
        $this->tag = !empty($rec['tag']) ? $rec['tag'] : null;
    }

    public static function fromPost($post)
    {
        $rec1['id'] = !empty($post['trip_tag_id']) ? $post['trip_tag_id'] : -1;
        $rec1['tag'] = $post['trip_tag_tag'];
        $new = new static($rec1);
        return $new;
    }

    public static function fromDatabase($db)
    {
        $rec1['id'] = $db['id'];
        $rec1['created'] = $db['created'];
        $rec1['tag'] = $db['tag'];
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
    public function tag()
    {
        return $this->tag;
    }

    public function toString($pretty = false)
    {
        $obj = (object) [
            "id" => $this->id(),
            "created" => $this->created(),
            "tag" => $this->tag()
        ];

        if ($pretty === true)
            return json_encode(get_object_vars($obj), JSON_PRETTY_PRINT);

        return json_encode(get_object_vars($obj));
    }
}
