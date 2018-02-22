<?php
namespace Model\Interfaces;
use Model\Table\ListingsTable;
interface ListingsTableAwareInterface 
{
    public function setListingsTable(ListingsTable $table);
}
