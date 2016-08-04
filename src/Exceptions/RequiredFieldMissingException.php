<?php

namespace TurboShip\Api\Exceptions;


class RequiredFieldMissingException extends \Exception implements \JsonSerializable
{

    /**
     * @var     string
     */
    public $entity;

    /**
     * @var     string
     */
    public $field;

    
    /**
     * RequiredFieldMissingException constructor.
     * @param   string      $entity
     * @param   int         $field
     * @param   \Exception|null $previous
     */
    public function __construct($entity, $field, \Exception $previous = null)
    {
        $message            = $entity . ': ' . $field . ' is required';

        parent::__construct($message, 400, $previous);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'Exception'         => 'RequiredFieldMissingException',
            'code'              => $this->code,
            'entity'            => $this->entity,
            'field'             => $this->field,
        ];
    }


}