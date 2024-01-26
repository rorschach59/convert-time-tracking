<?php

namespace App\Services;

class ReportService
{

    public function __construct(private TimecampService $timecampService)
    {
    }

    /**
     * @param string $from
     * @param string $to
     * @return array
     */
    public function getTasks(string $from, string $to): array
    {
        $timeEntries = $this->timecampService->getTimeEntries($from, $to);
        $timeEntries = is_null($timeEntries) ? null : json_decode($timeEntries);
        $tasks = [];
        $total = 0;

        foreach ($timeEntries as $timeEntry) {

            if (array_key_exists($timeEntry->task_id, $tasks)) {
                $tasks[$timeEntry->task_id]['duration'] += $timeEntry->duration;
            } else {
                $tasks[$timeEntry->task_id]['name'] = $timeEntry->name;
                $tasks[$timeEntry->task_id]['duration'] = (int) $timeEntry->duration;
            }

            $total += $timeEntry->duration;
        }

        $tasks[0]['name'] = 'Total';
        $tasks[0]['duration'] = $total;
        return $tasks;
    }

}
