<?php

namespace TurboShip\Api\Exceptions;


class EntityNotFoundException extends \Exception implements \JsonSerializable
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
     * EntityNotFoundException constructor.
     * @param   string      $entity
     * @param   int         $field
     * @param   \Exception|null $previous
     */
    public function __construct($entity, $field, \Exception $previous = null)
    {
        $message            = $entity . ': ' . $field . ' is required';

        parent::__construct($message, 404, $previous);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'Exception'         => 'EntityNotFoundException',
            'code'              => $this->code,
            'entity'            => $this->entity,
            'field'             => $this->field,
        ];
    }

}