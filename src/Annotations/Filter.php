<?php
namespace Redbox\Hooks\Annotations;

/**
 * @Annotation
 */
class Filter
{
    private $propertyName;
    private $dataType = 'string';
    private $options = [];
    public $priority = 0;

    public function __construct($options = [])
    {
        if (isset($options['value'])) {
            $options['propertyName'] = $options['value'];
            unset($options['value']);
        }

        $this->priority = 10;

        $default = [
            'priority' => 10,
        ];

        foreach ($default as $key => $value) {
            if (isset($options[$key]) == false) {
                $options[$key] = $value;
            }
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }

        $this->options = $options;
    }

    public function getPropertyName()
    {
        return $this->propertyName;
    }

    public function getDataType()
    {
        return $this->dataType;
    }
}
