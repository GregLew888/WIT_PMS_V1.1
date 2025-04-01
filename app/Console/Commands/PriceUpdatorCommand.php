<?php

namespace App\Console\Commands;

use App\Services\PriceUpdateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PriceUpdatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Symbols prices';

    /**
     * The PriceUpdateService instance.
     *
     * @var PriceUpdateService
     */
    protected $priceService;

    public function __construct(PriceUpdateService $priceService)
    {
        parent::__construct();
        $this->priceService = $priceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("start updating prices");
        $this->priceService->perform();
        $this->info('process completed successfully');

        return Command::SUCCESS;
    }
}
