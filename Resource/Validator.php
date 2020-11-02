<?php

namespace Resource;

use DateTime;
use ZxcvbnPhp\Zxcvbn;

class Validator
{
    /**
     * atributes arrays;
     *
     * @var array
     */
    private $errors = [];
    protected $fields = [];
    protected $number = [];
    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        array_push($this->errors, $errors);
    }
    /**
     * validate fields
     *
     * @param array $param
     * @return void
     */
    public function validateFields(array $param, string $errorMessage = null)
    {
        $i = 0;
        foreach ($param as $key => $value) {
            if (empty($value)) {
                $i++;
                $fail = $errorMessage ?? 'The ' . $key . ' is required field.';
                $this->setErrors($fail);
            }
        }
        if ($i == 0) {
            return true;
        } else {
            
            return false;
        }
    }
    /**
     * validate email
     *
     * @param [type] $param
     * @return boolean
     */
    public function isValidEmail(string $param, string $errorMessage = null)
    {
        if (filter_var($param, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            $this->setErrors($errorMessage ?? "The email is Invalid.");
            return false;
        }
    }
    /**
     * validate date
     *
     * @param [type] $param
     * @return boolean
     */
    public function isValidDate($param, string $errorMessage = null)
    {
        $data = DateTime::createFromFormat("d/m/y", $param);
        if ($data && ($data->format("d/m/y") == $param)) {
            return true;
        } else {
            $this->setErrors($errorMessage ?? "The date is Invalid.");
            return false;
        }
    }
    /**
     * check if is unique data
     *
     * @param [type] $param
     * @param [type] $model
     * @param [type] $column
     * @return boolean
     */
    public function isUnique(string $param,  $model, string $column, string $errorMessage = null)
    {
        $params = http_build_query(["clause" => $param]);
        $data = $model->find($column . '=:clause', $params)->fetch(true);
        if (empty($data)) {
            return true;
        } else {
            $this->setErrors($errorMessage ?? "The " . $column . " allrady exist.");
            return false;
        }
    }
    /**
     * check if is unique data
     *
     * @param [type] $param
     * @param [type] $model
     * @param [type] $column
     * @return boolean
     */
    public function isUniqueEdit(int $id, string $param,  $model, string $column, string $errorMessage = null)
    {
        $params = http_build_query(["clause" => $param, 'id'=>$id]);
        $data = $model->find($column . '=:clause and id != :id', $params)->fetch(true);
        if (empty($data)) {
            return true;
        } else {
            $this->setErrors($errorMessage ?? "The " . $column . " allrady exist.");
            return false;
        }
    }
    /**
     * chack if is exist on database data
     *
     * @param [type] $param
     * @param [type] $model
     * @param [type] $column
     * @return boolean
     */
    public function isExist(string $param,  $model, string $column)
    {
        $params = http_build_query(["clause" => $param]);
        $data = $model->find($column . '=:clause', $params)->fetch(true);
        if (empty($data)) {
            return false;
        } else {

            return true;
        }
    }
    /**
     * verifay  passwd hash if exist
     *
     * @param [type] $param
     * @param [type] $password
     * @param [type] $model
     * @param [type] $column
     * @return boolean
     */
    public function isValidPassword(string $uniquiParam, $model, string $column, string $password, string $columnPasswordName=null)
    {
        $params = http_build_query(["clause" => $uniquiParam]);
        $data = $model->find($column . '=:clause', $params)->fetch();
        if (empty($data)) {
            return false;
        } else {
            if ($columnPasswordName == null) {
                $hash = $data->password;
            }else{
                $hash = $data->$columnPasswordName;
            }

            return password_verify($password, $hash);
            
        }
        
    }
    /**
     * check if is number
     *
     * @param [type] $param
     * @return boolean
     */
    public function isNumber( $param, string $errorMessage = null)
    {
        if (!filter_var($param, FILTER_SANITIZE_NUMBER_INT) && !is_numeric($param)) {
            $this->setErrors($errorMessage);
            return false;
        } else {
            
            return true;
        }
    }
    /**
     * confirm if password == confirmPassword
     *
     * @param [type] $password
     * @param [type] $confirmPassword
     * @return boolean
     */
    public function isValidConfirmPasswd(string $password, string $confirmPassword, string $errorMessage = null)
    {
        if ($password == $confirmPassword) {
            return true;
        } else {
            $this->setErrors($errorMessage ?? "The confirm password not match.");
            return false;
        }
    }
    /**
     * check if password is strong
     *
     * @param [type] $password
     * @param [type] $param
     * @return boolean
     */
    public function isStrongPassword(string $password, int $strongerSize=1, string $errorMessage = null)
    {
        $zxcvbn = new Zxcvbn();
        $strong = $zxcvbn->passwordStrength($password);
        if( $strong['score'] >=$strongerSize)
        {
            return true;
        }else {
            $this->setErrors($errorMessage ?? "The  password is not strong, at least 4 digits  may contain char and number.");
            return false;
        }
    }
}
