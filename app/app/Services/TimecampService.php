<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class TimecampService
{

    private const URL = 'https://app.timecamp.com/third_party/api/';

    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/timecamp_service.log'),
        ]);
    }

    /**
     * @param string $from
     * @param string $to
     * @return string|null
     */
    public function getTimeEntries(string $from, string $to): ?string
    {
        try {
            return Http::withToken(env('TIMECAMP_BEARER'))
                ->withHeader('Accept', 'application/json')
                ->get(self::URL . 'entries?from=' . $from . '&to=' . $to)
                ->body()
            ;
        } catch (\Exception $e) {
            $this->logger->error($e);
        }

        return null;

    }
}
