<?php

namespace Themis\Model\DataObject;

abstract class AbstractDataObject
{
    /**
     * Permet de retourner toutes les colonnes d'une table
     *
     * @return array
     */
    public abstract function tableFormat(): array;

    /**
     * Permet de construire un objet à partir d'une array
     *
     * @param array $formArray
     * @return AbstractDataObject
     */
    public abstract static function buildFromForm(array $formArray): AbstractDataObject;
}