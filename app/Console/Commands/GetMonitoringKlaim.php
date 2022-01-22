<?php

namespace App\Console\Commands;

use App\Http\Controllers\Bridging\NewVClaimController;
use App\Models\Bridging\BpjsMonitoringKlaim;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Console\Command;

class GetMonitoringKlaim extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vclaim:get_monitoring_claim';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'VClaim Get Monitoring Claim';

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
     * @return mixed
     */
    public function handle()
    {
        $period = new DatePeriod(
            new DateTime('2021-12-01'),
            new DateInterval('P1D'),
            new DateTime()
        );

        $arr_dates = [];
        foreach ($period as $date) {
            $arr_dates[] = $date->format('Y-m-d');
        }

        if (count($arr_dates) > 0) {
            foreach ($arr_dates as $date) {
                $current_data = BpjsMonitoringKlaim::where('TglPulang', $date)->get();

                if (count($current_data) == 0) {
                    $vclaim = new NewVClaimController();
                    $response = $vclaim->dataKlaim($date, 1, 3);
                    echo json_encode($response);
                    echo PHP_EOL;

                    if (isset($response['metaData'])) {
                        if ($response['metaData']['code'] == 201) {
                            $err = true;
                        }

                        if ($response['metaData']['code'] == 200) {
                            $scs = true;
                        }
                    } else {
                        $scs = true;
                    }
                }
            }
        }
    }
}
