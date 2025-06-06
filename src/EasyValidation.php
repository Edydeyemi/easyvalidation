<?php

declare(strict_types=1);

namespace Edydeyemi;

/**
 * Summary of EasyValidation
 * 
 * @param string $errors Error meesage returned by method
 * @param string $field The name of form field to be validated.
 * @param mixed $value The value of form field to be validated/compared.
 * @param mixed $control The value to compare against.
 * @param array $bucket 
 * 
 * @return $this Instance of the class for method chaining. * 
 */
class EasyValidation
{

    public ?string $errors = null;
    private string $field;
    private string $value;
    public array $bucket = [];


    /**
     * Store values in the bucket.
     *
     * Stores the field and value of the instance in the bucket.
     *
     * @return void
     */
    public function storeValues(): void
    {
        $this->bucket[] = [$this->field => $this->value];
    }

    /**
     * dumpValue
     *
     * This method returns the values stored in the bucket.
     *
     * @return array The values stored in the bucket.
     */
    public function dumpValue(): array
    {
        // Return the bucket containing the values stored in the instance.
        return $this->bucket;
    }

    /**
     * setField
     *
     * @param string $field Name of form field
     * @param string|int $value Value of form field
     * @return object
     */
    public function setField(string $field, string|int|null $value): object
    {
        $this->field = trim(strtolower($field));
        $this->value = trim($value);
        return $this;
    }

    /**
     * STRING VALIDATION
     *
     * Validates if the value is empty.
     *
     * @return $this Instance of the class for method chaining
     */
    public function required(): self
    {
        // If the value is empty, store the error message
        if (empty($this->value)) {
            $this->errors = $this->field . "_error";
        }

        // Store the value in the bucket
        $this->storeValues();

        // Return the instance of the class for method chaining
        return $this;
    }


    /**
     * Email Validation
     *
     * Validates if the value is a valid email address.
     *
     * @return $this Instance of the class for method chaining
     */
    public function isEmail()
    {

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    /**
     * URL Validation
     *
     * Validates if the value is a valid URL.
     *
     * @return $this Instance of the class for method chaining
     */

    public function isUrl()
    {

        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }


    /**
     * Validates if the value is in the given array.
     *
     * @param array $array The array to check against.
     * @return $this Instance of the class for method chaining.
     */
    public function inArray(array $array)
    {
        if (!in_array($this->value, $array)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }


    public function equals($control)
    {
        if ($this->value !== $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    /**
     * NUMERIC VALIDATION
     */
    public function min(int|float $control)
    {
        if ($this->value < $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }


    /**
     * Validates if the value is greater than the given control.
     *
     * @param int|float $control The value to compare against.
     * @return $this Instance of the class for method chaining.
     */
    public function max(int|float $control)
    {
        if ($this->value > $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    /**
     * Validates if the value is a numeric value.
     *
     * @return $this Instance of the class for method chaining.
     */
    public function isNumeric()
    {
        if (!is_numeric($this->value)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function isFloat()
    {
        if (!is_float($this->value)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    /**
     * DATE VALIDATION
     */
    public function isDate($format = 'Y-m-d')
    {
        $date = \DateTime::createFromFormat($format, $this->value);
        if (!$date) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    function isToday($format = 'Y-m-d')
    {
        $today = \DateTime::createFromFormat($format, date($format, time()));
        $date = \DateTime::createFromFormat($format, $this->value);

        if ($date != $today) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function beforeToday($format = 'Y-m-d')
    {
        $today = \DateTime::createFromFormat($format, date($format, time()));
        $date = \DateTime::createFromFormat($format, $this->value);

        if ($date >= $today) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function afterToday($format = 'Y-m-d')
    {
        $today = \DateTime::createFromFormat($format, date($format, time()));
        $date = \DateTime::createFromFormat($format, $this->value);

        if ($date <= $today) {

            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function beforeTomorrow($format = 'Y-m-d')
    {
        $today = \DateTime::createFromFormat($format, date($format, time()));
        $date = \DateTime::createFromFormat($format, $this->value);

        if ($date > $today) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function afterYesterday($format = 'Y-m-d')
    {
        $today = \DateTime::createFromFormat($format, date($format, time()));
        $date = \DateTime::createFromFormat($format, $this->value);

        if ($date < $today) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function dateNotBefore(string $control)
    {
        $this->value = strtotime($this->value);
        $control = strtotime($control);
        if ($this->value < $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function dateNotAfter(string $control)
    {

        $this->value = strtotime($this->value);
        $control = strtotime($control);
        if ($this->value > $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }


    /**
     * GENERIC VALIDATION
     */
    public function NotGreaterThan($control)
    {

        if ($this->value > $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function NotLesserThan($control)
    {
        if ($this->value < $control) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function isValidLat()
    {

        if (!is_numeric($this->value) || !(-90 <= $this->field) && !($this->field <= 90)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }

    public function isValidLongt()
    {
        if (!is_numeric($this->value) || !(-180 <= $this->field) && !($this->field <= 180)) {
            $this->errors = $this->field . "_error";
        }
        $this->storeValues();
        return $this;
    }
}
