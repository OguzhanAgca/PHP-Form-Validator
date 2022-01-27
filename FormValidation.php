<?php

class FormValidation
{
    private $name;
    private $value;
    private $errorMsg = [];

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    public function validation($field)
    {
        switch ($field) {
            case "name":
            case "lastname":
                if (!preg_match('/^[A-ZİĞÜŞÇÖa-züiçşğı]{2,20}$/', $this->value)) {
                    $this->errorMsg[$this->name] = "{$this->name} field cannot contain spaces, must be between 2 and 20 characters and contain only letters.";
                }
                return $this;
            case "email":
                if (!filter_var($this->value, FILTER_VALIDATE_EMAIL) ? true : false) {
                    $this->errorMsg[$this->name] = "Please enter a valid {$this->name}.";
                }
                return $this;
            case "username":
                if (!preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z_-]$/', $this->value)) {
                    $this->errorMsg[$this->name] = "{$this->name} is not valid.";
                }
                return $this;
            case "password":
                if (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $this->value)) {
                    $this->errorMsg[$this->name] = "{$this->name} is not strong enough.";
                }
                return $this;
        }
    }

    public function fileValidation(string $fileName, int $fileSize, int $allowedSize, array $allowedExt)
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedSize = number_format($allowedSize / 1048576, 2, ".", null); // Byte -> Mb
        $fileSize = number_format($fileSize / 1048576, 2, ".", null); // Byte -> Mb

        $allowedExtStr = "";
        foreach ($allowedExt as $value) {
            $allowedExtStr .= " $value";
        }

        if (!in_array($ext, $allowedExt)) {
            $ext ? $this->errorMsg[$this->name] = "You can upload only $allowedExtStr files." : null;
        }

        if ($allowedSize < $fileSize) {
            $this->errorMsg[$this->name] = "The file size cannot be larger than $allowedSize MB.";
        }

        return $this;
    }

    public function customValidation($pattern, $msg)
    {
        if (!preg_match($pattern, $this->value)) {
            $this->errorMsg[$this->name] = $msg;
        }

        return $this;
    }

    public function required()
    {
        if (mb_strlen($this->value) <= 0) {
            array_push($this->errorMsg, "Please fill in all fields.");
        }
        return $this;
    }

    public function isSuccess()
    {
        if (count($this->errorMsg) > 0) {
            return $this->errorMsg;
        } else {
            return true;
        }
    }
}
