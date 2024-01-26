<?php

namespace App\Console\Commands;

use App\Mail\ReportMail;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Mail;

class Report extends Command implements PromptsForMissingInput
{

    private const DAILY = 'daily';
    private const WEEKLY = 'weekly';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:report {frequence : ' . self::DAILY . ' or ' . self::WEEKLY . '}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(protected ReportService $reportService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $frequence = $this->argument('frequence');
        $from = $to = Carbon::now()->format('Y-m-d');
        $mailTitle = 'Temps à tracker du ' . $to;

        if ($frequence === self::WEEKLY) {
            $from = Carbon::now()->startOfWeek()->format('Y-m-d');
            $mailTitle = 'Temps à tracker du ' . $from . ' au ' . $to;
        }

        $tasks = $this->reportService->getTasks($from, $to);

        Mail::to('contact@remipouly.fr')->send(new ReportMail(
            $tasks, $mailTitle
        ));
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'frequence' => 'Souhaitez-vous le rapport ' . self::DAILY . ' ou ' . self::WEEKLY . ' ?',
        ];
    }
}
