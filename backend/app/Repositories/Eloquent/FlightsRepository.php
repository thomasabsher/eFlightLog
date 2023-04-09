<?php

namespace App\Repositories\Eloquent;

use App\Models\Flights;
use App\Models\Aircrafts;

use App\Repositories\FlightsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FlightsRepository extends BaseRepository implements FlightsRepositoryInterface
{
    public function __construct(Flights $model)
    {
        parent::__construct($model);
    }

    public function findAll($params) : array
    {
        $limit = 0;
        $offset = 0;
        $orderBy = null;

        $query = $this->model->newModelQuery();
        //$query->select("*", "product as prod_id");

        $query->with('aircraft');

        if (isset($params['filter'])) {
            $filter = $params['filter'];

            if (isset($filter['type'])) {
                $query->where('type', 'like', '%'.$filter['type'].'%');
            }

            if (isset($filter['comments'])) {
                $query->where('comments', 'like', '%'.$filter['comments'].'%');
            }

            if (isset($filter['dateRange'])) {
                [$start, $end] = $filter['dateRange'];

                if (!empty($start)) {
                    $query->where('date', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('date', '<=', $end);
                }
            }

            if (isset($filter['durationRange'])) {
                [$start, $end] = $filter['durationRange'];

                if (!empty($start)) {
                    $query->where('duration', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('duration', '<=', $end);
                }
            }

            if (isset($filter['active'])) {
                $query->where('active', $params['active']);
            }

            if (isset($filter['createdAtRange'])) {
                [$start, $end] = $filter['createdAtRange'];

                if (!empty($start)) {
                    $query->where('created_at', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('created_at', '<=', $end);
                }
            }
        }

        if ($limit) {
            $query->limit($limit);
        }

        $rows = $query->get();

        return [
            'rows' => $rows->toArray(),
            'count' => $rows->count(),
        ];
    }

    public function create(array $attributes, $currentUser)
    {
        try {
            $attributes = $attributes['data'];
            DB::beginTransaction();
            $attributes['created_by_user'] = $currentUser->id;
            $flights = Flights::create([
                    'type' => $attributes['type'] ?? null
,
                    'date' => $attributes['date'] ?? null
,
                    'duration' => $attributes['duration'] ?? null
,
                    'aircraft' => $attributes['aircraft'] ?? null
,
                    'comments' => $attributes['comments'] ?? null
,
                    'created_by_user' => $currentUser->id
                ]);

            DB::commit();

            return [];
        } catch (Exception $exception) {
            DB::rollback();
        }
    }

    public function update($id, array $attributes, $currentUser)
    {
        try {
            $attributes = $attributes['data'];
            DB::beginTransaction();
            $flights = Flights::find($id);
            $flights->update([
                    'type' => $attributes['type'] ?? null
,
                    'date' => $attributes['date'] ?? null
,
                    'duration' => $attributes['duration'] ?? null
,
                    'aircraft' => $attributes['aircraft'] ?? null
,
                    'comments' => $attributes['comments'] ?? null
,
                    'updated_by_user' => $currentUser->id
                ]);

            DB::commit();

            return [];
        } catch (Exception $exception) {
            DB::rollback();
        }
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function findById($id)
    {
        $query = $this->model->newModelQuery();

        $query
            ->with('aircraft')
            ->where('id', $id);

        return $query->get()[0];
    }

    public function findAllAutocomplete(array $params)
    {
        $query = $this->model->newModelQuery();

        $query->select('*', 'type as label');

        if (isset($params['query'])) {
            $query->where('type', 'like', '%'.$params['query'].'%');
        }

        if (isset($params['limit'])) {
            $query->limit($params['limit']);
        }

        $query->orderBy('type', 'ASC');

        return $query->get()
            ->map(fn($item) => ['id' => $item->id, 'label' => $item->label]);
    }
}

