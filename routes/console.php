<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('comparateur:export-csv', function () {
    $this->call('App\Console\Commands\ExportComparateurCsv');
})->purpose('Exporte et envoie les fichiers CSV aux comparateurs');

Artisan::resolveConsoleSchedule()->command('comparateur:export-csv')
    ->dailyAt('03:00')
    ->withoutOverlapping()
    ->sendOutputTo(storage_path('logs/comparateur_export.log'));
