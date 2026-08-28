<?php

namespace App\Interfaces;

interface EmployerStatisticRepositoryInterface
{
    public function getJobsCountPerMonth(int $companyId, int $year);
    public function getApplicationsCountPerMonth(int $companyId, int $year);
    public function getJobsByCategory(int $companyId);
}