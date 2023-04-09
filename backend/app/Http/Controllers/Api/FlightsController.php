<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\FlightsRepositoryInterface;

class FlightsController extends Controller
{
    protected FlightsRepositoryInterface $flightsRepository;
    protected Request $request;

    public function __construct(FlightsRepositoryInterface $flightsRepository, Request $request)
    {
        $this->flightsRepository = $flightsRepository;
        $this->request = $request;
    }

    public function index()
    {
        $payload = $this->flightsRepository->findAll($this->request->all());

        $fileType = request()->query('filetype');
        if($fileType && $fileType == 'csv') {
            header("Content-type: text/csv");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="flights.csv"');
            $rows = $payload['rows'];
            $fields = array('id','FlightType','Comments',

        'Duration',
      'Date',
        );

            $f = fopen('php://output', 'w');

            fputcsv($f, $fields);

            foreach($rows as $row)
                {
                    fputcsv($f, array($row['id'],$row['type'],$row['comments'],

        $row'duration'],
      $row['date'],
        ));
                }

            fclose($f);

        } else {
            return response()->json($payload);
        }
    }

    public function count()
    {
        $payload = $this->flightsRepository->findAll($this->request->all());

        $countPayload = ['count' => $payload['count']];
        return response()->json($countPayload);
    }

    public function show($id)
    {
        $payload = $this->flightsRepository->findById($id);

        return response()->json($payload);
    }

    public function store()
    {
        $payload = $this->flightsRepository->create($this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function update($id)
    {
        $payload = $this->flightsRepository->update($id, $this->request->all(), auth()->user());

        return response()->json($payload);
    }

    public function destroy($id)
    {
        $this->flightsRepository->destroy($id);

        return response()->json(true, 204);
    }

    public function findAllAutocomplete()
    {
        $payload = $this->flightsRepository->findAllAutocomplete($this->request->only(['query', 'limit']));

        return response()->json($payload);
    }
}

