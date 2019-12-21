<?php

namespace MetodikaTI\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MetodikaTI\PackagesBuyedByUser;

class DisabledPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disabled:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to disabled packages when disabled_at date is above the current date.';

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

        $packages_buyed_by_users = PackagesBuyedByUser::where("status", "APPROVED")->get();

        foreach ($packages_buyed_by_users as $package_buyed_by_user){

            $package_disabled_at = Carbon::createFromFormat("Y-m-d H:i:s", $package_buyed_by_user->package_disbaled_at);
            $now = Carbon::now();

            if( $package_disabled_at->lessThan($now) ){
                PackagesBuyedByUser::where("id", $package_buyed_by_user->id)->delete();
            }

        }

    }

}









