@inject('dateService', 'App\Services\DateService')

<style>
    th, td {
        border: black 1px solid;
        padding: 0.5em;
    }
    table tr:last-child > td:first-child {
        text-align: right;
        font-weight: bold;
    }
</style>

<h1>Temps à tracker du {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h1>

<table>
    <thead>
    <tr>
        <th>Tâche</th>
        <th>Heure</th>
        <th>J/H</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        @if($loop->last)
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        <tr>
            <td>{{ $task['name'] }}</td>
            <td>{{ $dateService->getHoursFromSeconds($task['duration']) }}</td>
            <td>{{ $dateService->convertTimeInManDay($dateService->getHoursFromSeconds($task['duration'])) }}</td>
        </tr>

    @endforeach
    </tbody>
</table>
