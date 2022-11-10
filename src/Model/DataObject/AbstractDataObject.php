<?php

namespace Themis\Model\DataObject;

abstract class AbstractDataObject
{
    public abstract function tableFormat(): array;
}