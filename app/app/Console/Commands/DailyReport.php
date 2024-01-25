<?php

namespace App\Console\Commands;

use App\Mail\DailyReportMail;
use App\Services\TimecampService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(private TimecampService $timecampService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $from = $to = Carbon::now()->format('Y-m-d');
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

        Mail::to('contact@remipouly.fr')->send(new DailyReportMail($tasks));
    }
}
