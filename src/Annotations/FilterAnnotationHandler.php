<?php
namespace Redbox\Hooks\Annotations;

use Doctrine\Common\Annotations\Reader;
use Redbox\Hooks\Filters;

class FilterAnnotationHandler
{
    private $reader;
    private $annotationClass = 'Redbox\Hooks\Annotations\Filter';

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function read($object)
    {


        $reflectionObject = new \ReflectionObject($object);

        foreach ($reflectionObject->getMethods() as $reflectionMethod) {

            /**
             * Weird but still be need to do this.
             */
            new $this->annotationClass;

            /**
             * Autoload or instantiate the object
             */
            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

            Filters::addFilter(
                $annotation->getPropertyName(),
                [$object, $reflectionMethod->name],
                $annotation->priority
            );
        }
    }
}
