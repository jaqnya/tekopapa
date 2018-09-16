<?php
abstract class BaseModel {

    protected $company_id;
    protected $id;
    protected $name;
    protected $active;
    protected $created_at;
    protected $updated_at;

    public function __construct($company_id, $id, $name, $active, $created_at, $updated_at) {
        $this->company_id = $company_id;
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function get_company_id() {
        return $this->company_id;
    }

    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function is_active() {
        return $this->active;
    }

    public function set_active($active) {
        $this->active = $active;
    }

    public function get_created_at() {
        return $this->created_at;
    }

    public function get_updated_at() {
        return $this->updated_at;
    }

}
?>