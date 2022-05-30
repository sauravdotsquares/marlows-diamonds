<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DiamondStock;
use App\Models\HariKrishna;

class DemoCrone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:crone';

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
        $this->info('successfully');
        $basket_data = DiamondStock::get()->toArray();
        HariKrishna::truncate();
        foreach($basket_data as $records)
        {
            unset($records['id']);
            $records['created_at'] = date('Y-m-d h:i:s');
            $records['updated_at'] = date('Y-m-d h:i:s');
            HariKrishna::create($records);
        }
        echo "done sdfdf";
        // return 0;
        // $this->info("demo:crone Crone Run Successfully");
    }
}
