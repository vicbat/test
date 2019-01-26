<?php
/**
 * Created by PhpStorm.
 * User: _
 * Date: 26.01.2019
 * Time: 16:24
 */

namespace App\Http\Controllers;

use App\Jobs\parserFile;
use App\Repository\MemberRepo;
use App\Repository\StatisticsRepo;
use Illuminate\Http\Request;

class HandlerController extends Controller
{
    private $memberRepo;
    private $statisticsRepo;
    private $countBlockLines =100000;

    public function __construct(MemberRepo $memberRepo, StatisticsRepo $statisticsRepo)
    {
        $this->memberRepo = $memberRepo;
        $this->statisticsRepo = $statisticsRepo;
    }

    public function index()
    {
        return view('handler');
    }

    public function hander (Request $request)
    {

        if ($file=$request->file('file')) {
            if ($file->isValid()) {
                $filename = 'file_' . time() . rand(10,20) . '.' . $file->extension();
                $filename = $file->storeAs('upload', $filename);
                $this->handlerFile($filename);
            }
        }

        return redirect()->back();
    }

    private function handlerFile ($filename)
    {
        if($handler = fopen(storage_path('app\\'.$filename), "rb")) {
            $countLines = 0;
            while(!feof($handler)) {
                fgets($handler);
                $countLines++;
            }

            $this->createStatistics([
                    'filename' => $filename,
                    'members_all' => $countLines
                ]);

            $countHandlers = intval(ceil($countLines / $this->countBlockLines));
            for($i = 0; $i < $countHandlers; $i++) {
                $this->parserFile($filename,$i*$this->countBlockLines);
                //dispatch(new parserFile($filename,$i*$this->countBlockLines,$this->memberRepo, $this->statisticsRepo));
            }

        }
    }

    private function parserFile ($filename,$line)
    {
        $currentLine = $line;
        if($handler = fopen(storage_path('app\\'.$filename), "rb")) {
            while(!feof($handler) && $line--) {
                fgets($handler);
            }
        }
        $line = $this->countBlockLines;
        $repoS = $this->statisticsRepo->statisticsOfFileName($filename);
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

    private function createStatistics($all)
    {
        $this->statisticsRepo->create($this->statisticsRepo->perpareData($all));
    }

}
