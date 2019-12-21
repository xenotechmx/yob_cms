<?php

namespace MetodikaTI\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MetodikaTI\Job;

class DisabledJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disabled:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to disabled jobs when disabled_at date is above the current date.';

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

        $jobs = Job::where("status", "publish")->get();

        foreach ($jobs as $job){

            $job_disabled_at = Carbon::createFromFormat("Y-m-d H:i:s", $job->disbaled_at);
            $now = Carbon::now();

            echo $job_disabled_at->format("Y-m-d H:i:s");

            if( $job_disabled_at->lessThan($now) ){
                Job::where("id", $job->id)->delete();
            }

        }

    }
}
