<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\PilotsRepositoryInterface;

class PilotsController extends Controller
{
    protected PilotsRepositoryInterface $pilotsRepository;
    protected Request $request;

    public function __construct(PilotsRepositoryInterface $pilotsRepository, Request $request)
    {
        $this->pilotsRepository = $pilotsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->pilotsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="pilots.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Name','License',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['name'],$row['license'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->pilotsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->pilotsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->pilotsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->pilotsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->pilotsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->pilotsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

