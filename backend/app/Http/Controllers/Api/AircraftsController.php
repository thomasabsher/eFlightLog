<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\AircraftsRepositoryInterface;

class AircraftsController extends Controller
{
    protected AircraftsRepositoryInterface $aircraftsRepository;
    protected Request $request;

    public function __construct(AircraftsRepositoryInterface $aircraftsRepository, Request $request)
    {
        $this->aircraftsRepository = $aircraftsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->aircraftsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="aircrafts.csv"');
            $rows = $payload['rows'];
            $fields = array('id','Make','Model','Registration',
        'Year',

        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['make'],$row['model'],$row['registration'],
        $row['year'],

        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->aircraftsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->aircraftsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->aircraftsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->aircraftsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->aircraftsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->aircraftsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

