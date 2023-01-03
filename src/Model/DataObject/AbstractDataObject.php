<?php

namespace Themis\Model\DataObject;

abstract class AbstractDataObject
{
    /**
     * @return array
     */
    public abstract function tableFormat(): array;

    /**
     * @param array $formArray
     * @return AbstractDataObject
     */
    public abstract static function buildFromForm(array $formArray): AbstractDataObject;
}