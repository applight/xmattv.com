<?php
class FormBuilder {

    
    private $method;
    private $action;
    private $fields = [];

    private function __construct($method, $action) {
        $this->method = $method;
        $this->action = $action;
    } 

    public function Text($label, $id, $name, $regex) {
        $fields[] = new Text($label, $id, $name, $regex);
        return $this;
    }
};

abstract class Field {};

class Text extends Field {
    private $label, $id, $name, $regex, $required, $placeholder;
    public function __construct($label, $id, $name, $regex, $required=false, $placeholder="") {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->regex = $regex;   
    }

    public function print() {
        return "<label for=\"{$this->name}\">First name:</label>"
            . "<input type=\"text\" id=\"{$this->id}\" pattern=\"{$this->regex}\" "
            . "name=\"{$this->name}\" "
            . "placeholder=\"{$this->placeholder}\" "
            . ( $required ? "required" : "" ) . " >"; 
    }
};

class Submit extends Field {
    private $value;
    public function __construct($value) {
        $this->value = $value;
    }

    public function print() {
        return "<input type=\"submit\" value=\"{$this->value}\">";
    }
};

?>