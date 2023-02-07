<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PadronController;
use Exception;

class UpdateCensus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:census';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update census daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
        $this->info('Init update census command');

        try{ 

            Log::info('Init Download');
            $download = app(PadronController::class)->download();
            $this->info('Download: '.$download['message']);
            Log::info('End Download: '.$download['message']);

            Log::info('Init Extractor');
            $extractor = app(PadronController::class)->extractor();
            $this->info('Extractor: '.$extractor['message']);
            Log::info('End Extractor: '.$extractor['message']);
            
            Log::info('Init Load data');
            $loadtdata = app(PadronController::class)->loadtdata();
            $this->info('Load data: '.$loadtdata['message']);
            Log::info('End Load data: '.$loadtdata['message']);


        }catch(Exception $e)
        {
            Log::info($e->getMessage());
        }

        $this->info('End update census command');
    }
}
