<?php


namespace Morebec\ObjectGenerator\Domain\Definition;


class UseDefinition
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var string|null
     */
    private $as;

    public function __construct(string $className, ?string $as = null)
    {
        $this->className = $className;
        $this->as = $as;
    }

    public function __toString()
    {
        $use = $this->className;
        $as = $this->as;
        return $as ? "$use as $as" : $use;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return string|null
     */
    public function getAs(): ?string
    {
        return $this->as;
    }

    /**
     * @param string|null $as
     */
    public function setAs(?string $as): void
    {
        $this->as = $as;
    }
}