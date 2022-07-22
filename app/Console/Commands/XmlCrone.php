<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\XMLController;

class XmlCrone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->line('Running my job at ' . date('Y-m-d h:i:s'));

        $xmlController = new XMLController;
        $xmlController->XMLFunction();
        // return 0;
        $this->line('Ending my job at ' . date('Y-m-d h:i:s'));
    }
}
