<?php

namespace App\Console\Commands;

use App\Models\Room;
use App\Repositories\Room\RoomRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateSalePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateSalePrice';

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
    public function __construct(RoomRepository $roomRepository)
    {
        parent::__construct();
        $this->roomRepository = $roomRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = date('m/d/Y');
        //Turn on sale status
        $rooms_id = $this->roomRepository->where('sale_start_at', '<=', $today)->pluck('id')->toArray();
        if (count($rooms_id) > 0) {
            $this->roomRepository->whereIn('id', $rooms_id)->update(['sale_status' => 1]);
        }
        //Turn off sale status
        $rooms_id = $this->roomRepository->where('sale_end_at', '<', $today)->pluck('id')->toArray();
        if (count($rooms_id) > 0) {
            $this->roomRepository->whereIn('id', $rooms_id)->update(['sale_status' => 0]);
        }
    }
}
