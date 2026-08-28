<?php

namespace App\Interfaces;

interface EmployerStatisticServiceInterface
{
    public function getDashboardStatistics(int $companyId, int $year);
}