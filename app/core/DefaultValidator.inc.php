<?php
include_once 'Utils.inc.php';

abstract class DefaultValidator {

    protected $notice_begin = '<div class="alert alert-danger" role="alert" style="border-radius: 5px; font-size: 0.8rem; margin-top: 0.5rem; padding: 0.2rem;">';
    protected $notice_end = '</div>';
    protected $repository = '';

    protected $id = 0;
    protected $name = '';
    protected $active = 0;

    protected $error_id = '';
    protected $error_name = '';
    protected $error_active = '';

    protected function variable_initiated($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    protected function validate_id($id) {
        if (!isset($id) || !is_int($id)) {
            return 'Por favor, escribe un c&#243;digo.';
        } else {
            $this->id = $id;
        }

        if ($id < 0) {
            return 'El c&#243;digo ser mayor que cero.';
        }

        if ($id > 16777215) {
            return 'El c&#243;digo ser menor a 16777215.';
        }

        return '';
    }

    protected function validate_name($connection, $name) {
        if (!$this->variable_initiated($name)) {
            return 'Por favor, escribe un nombre.';
        } else {
            $this->name = Utils::alltrim(Utils::upper($name));
        }

        if (strlen($this->name) < 6) {
            return 'El nombre es demasiado corto.';
        }

        if (strlen($this->name) > 50) {
            return 'El nombre es demasiado largo.';
        }

        if (is_int($this->id) && empty($this->id)) {
            if ($this->repository::name_exists($connection, $this->name)) {
                return 'Este nombre ya est&#225; en uso. Elige otro.';
            }
        } elseif (is_int($this->id) && !empty($this->id)) {
            $results = $this->repository::get_by_name($connection, $this->name);

            if (count($results)) {
                foreach ($results as $row) {
                    if ((int) $row->get_id() !== $this->id) {
                        return 'Este nombre ya est&#225; en uso. Elige otro.';
                    }
                }
            }
        }

        return '';
    }

    protected function validate_active($active) {
        if (!isset($active) || !is_bool($active)) {
            return 'Por favor, escribe si est&#225; vigente.';
        } else {
            $this->active = $active;
        }

        if ($active < 0 || $active > 1) {
            return 'La vigencia est&#225; determinada por un valor entre 0 y 1.';
        }

        return '';
    }

    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function is_active() {
        return $this->active;
    }

    public function show_id() {
        echo 'value="' . $this->id . '"';
    }

    public function show_name() {
        if ($this->name !== '') {
            echo 'value="' . $this->name . '"';
        }
    }

    public function show_active() {
        if ($this->active) {
            echo 'checked';
        }
    }

    public function get_error_id() {
        return $this->error_id;
    }

    public function get_error_name() {
        return $this->error_name;
    }

    public function get_error_active() {
        return $this->error_active;
    }

    public function show_error_id() {
        if ($this->error_id !== '') {
            echo $this->notice_begin . $this->error_id . $this->notice_end;
        }
    }

    public function show_error_name() {
        if ($this->error_name !== '') {
            echo $this->notice_begin . $this->error_name . $this->notice_end;
        }
    }

    public function show_error_active() {
        if ($this->error_active !== '') {
            echo $this->notice_begin . $this->error_active . $this->notice_end;
        }
    }

    public function is_valid() {
        if ($this->error_id === '' &&
                $this->error_name === '' &&
                $this->error_active === '') {
            return true;
        } else {
            return false;
        }
    }

}
?>