<?php

namespace Themis\Model\DataObject;

abstract class AbstractDataObject
{
    public abstract function tableFormatWithoutPrimaryKey(): array;

    public abstract function tableFormatWithPrimaryKey(): array;
}