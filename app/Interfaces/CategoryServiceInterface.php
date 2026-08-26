<?php

namespace App\Interfaces;

interface CategoryServiceInterface
{
    public function getAll(array $filters = []);
}