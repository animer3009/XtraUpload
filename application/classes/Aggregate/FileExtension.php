<?php

namespace Aggregate;

use Aggregate;

class FileExtension extends Aggregate
{
    const FILTER_WHITELIST = 'filter_whitelist';
    const FILTER_BLACKLIST = 'filter_blacklist';

    protected $filterType;

    public static function createFromPipedList($pipedExtensionList)
    {
        $extensions = explode('|', $pipedExtensionList);

        $aggregate = new self();

        foreach($extensions as $extension) {
            $aggregate->push( new \ValueObject\FileExtension($extension) );
        }

        return $aggregate;
    }

    public function __construct(array $items = array(), $filterType = self::FILTER_WHITELIST)
    {
        parent::__construct($items);

        $this->setFilterType($filterType);
    }

    public function setFilterType($filterType)
    {
        if (!in_array($filterType, array(self::FILTER_WHITELIST, self::FILTER_BLACKLIST))) {
            throw new \InvalidArgumentException("Argument one must be a valid filter.");
        }

        $this->filterType = $filterType;
    }

    public function getFilterType()
    {
        return $this->filterType;
    }
}