<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repository\MemberRepo;
use App\Repository\StatisticsRepo;
use Illuminate\Support\Facades\Log;

class parserFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $filename;
    protected $line;

    private $memberRepo;
    private $statisticsRepo;
    private $countBlockLines =100000;

    public function __construct($filename,$line, MemberRepo $memberRepo, StatisticsRepo $statisticsRepo)
    {
        //
        $this->filename = $filename;
        $this->line = $line;

        $this->memberRepo = $memberRepo;
        $this->statisticsRepo = $statisticsRepo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info('--------------crete job------------------'.$this->line.'---'.date('Y-m-d H:i:s'));

        $line = $this->line;
        $currentLine = $line;
        if($handler = fopen(storage_path('app\\'.$this->filename), "rb")) {
            while(!feof($handler) && $line--) {
                fgets($handler);
            }
        }
        $line = $this->countBlockLines;
        $repoS = $this->statisticsRepo->statisticsOfFileName($this->filename);
        $this->statisticsRepo->update($repoS, [
            'status' => 'Pending'
        ]);
        $countBadLine = 0;
        while(!feof($handler) && $line--) {
            try {
                $data = fgets($handler);
                $data = explode("\t", $data);
                $this->createMember([
                    'full_name' => $data[5],
                    'address' => $data[7] . $data[7],
                    'city' => $data[9],
                    'state' => $data[10],
                    'zipcode' => $data[11],
                    'is_union' => $data[12],
                    'member_number' => $data[3],
                    'email' => $data[26],
                    'phone' => $data[27],
                ]);
            } catch (\Exception $e) {
                $this->statisticsRepo->update($repoS, [
                    'errors' => $repoS->getError() . ($repoS->getError() ? ', ' : '') . $currentLine,
                ]);
                $countBadLine++;
            }
            $currentLine++;
        }
        if (!feof($handler)) {
            $line++;
        }
        $this->statisticsRepo->update($repoS, [
            'status' => 'Completed',
            'members_add' => $repoS->getMembersAdd() + $this->countBlockLines-$line-$countBadLine,
        ]);
    }

    private function createMember($all)
    {
        $this->memberRepo->create($this->memberRepo->perpareData($all));
    }
}
