<?php

namespace App\Core;

class Validator
{
    protected $validables = [];
    protected $errors = [];
    protected $request;

    public function __construct($data)
    {
        $this->validables = $data;
        $this->request = App::get('request')->request;
    }

    public function validate()
    {
        foreach ($this->validables as $name => $rule) {
            if (! method_exists($this, $rule)) {
                throw new \Exception("No validator method $rule present.");
            }
            $this->$rule($name);
        }

        return $this->errors;
    }

    private function required($name)
    {
        if (! $this->request->has($name)) {
            $this->errors = "Muuttujaa '$name' ei ole olemassa.";

            return false;
        }

        if (empty($this->request->get($name))) {
            $this->errors[] = "Muuttuja '$name' oli tyhjä.";

            return false;
        }

        return true;
    }
}