<?php
class FormBuilder {
    private $method;
    private $action;
    private $fields = [];

    public function __construct($method, $action) {
        $this->method = $method;
        $this->action = $action;
    } 

    public function name($label, $id, $name, $required=false) {
        return text($label, $id, $name, "/^[a-zA-Z]+$/", $required, $label);
    }

    public function email($id, $required=false) {
        return text("Email", $id, "email",
            "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", 
            $required, "email@example.com");
    }

    public function phone($id, $required=false) {
        return text("Phone number", $id, "phone",
        "/^(\+1)([0-9]{10})$/", true, "phone number");
    }

    public function text($label, $id, $name, $regex, $required, $placeholder) {
        $this->fields[] = new Text($label, $id, $name, $regex, $required, $placeholder);
        return $this;
    }

    public function submit($value) {
        $this->fields[] = new Submit($value);
    }

    public function toString() {
        $result = "<form action=\"{$this->action}\" method=\"{$this->method}\" >";
        foreach ( $this->fields as $field ) {
            $result = $result . $field->toString();
        }
        return $result . "</form>";
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
        $this->required = $required;
        $this->placeholder = $placeholder;   
    }

    public function toString() {
        $req = $this->required ? "required" : "";

        $str =<<<EOF
        <label for="{$this->name}">{$this->label}:</label>
        <input type="text" id="{$this->id}" pattern="{$this->regex}" name="{$this->name}" placeholder="{$this->placeholder}" {$req} >
        EOF;

        return $str;
    }
};

class Submit extends Field {
    private $value;
    public function __construct($value) {
        $this->value = $value;
    }

    public function toString() {
        return "<input type=\"submit\" value=\"{$this->value}\">";
    }
};

?>