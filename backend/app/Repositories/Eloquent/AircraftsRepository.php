<?php

namespace App\Repositories\Eloquent;

use App\Models\Aircrafts;

use App\Repositories\AircraftsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AircraftsRepository extends BaseRepository implements AircraftsRepositoryInterface
{
    public function __construct(Aircrafts $model)
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

        if (isset($params['filter'])) {
            $filter = $params['filter'];

            if (isset($filter['make'])) {
                $query->where('make', 'like', '%'.$filter['make'].'%');
            }

            if (isset($filter['model'])) {
                $query->where('model', 'like', '%'.$filter['model'].'%');
            }

            if (isset($filter['registration'])) {
                $query->where('registration', 'like', '%'.$filter['registration'].'%');
            }

            if (isset($filter['yearRange'])) {
                [$start, $end] = $filter['yearRange'];

                if (!empty($start)) {
                    $query->where('year', '>=', $start);
                }

                if (!empty($end)) {
                    $query->where('year', '<=', $end);
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
            $aircrafts = Aircrafts::create([
                    'make' => $attributes['make'] ?? null
,
                    'model' => $attributes['model'] ?? null
,
                    'registration' => $attributes['registration'] ?? null
,
                    'year' => $attributes['year'] ?? null
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
            $aircrafts = Aircrafts::find($id);
            $aircrafts->update([
                    'make' => $attributes['make'] ?? null
,
                    'model' => $attributes['model'] ?? null
,
                    'registration' => $attributes['registration'] ?? null
,
                    'year' => $attributes['year'] ?? null
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
            ->where('id', $id);

        return $query->get()[0];
    }

    public function findAllAutocomplete(array $params)
    {
        $query = $this->model->newModelQuery();

        $query->select('*', 'registration as label');

        if (isset($params['query'])) {
            $query->where('registration', 'like', '%'.$params['query'].'%');
        }

        if (isset($params['limit'])) {
            $query->limit($params['limit']);
        }

        $query->orderBy('registration', 'ASC');

        return $query->get()
            ->map(fn($item) => ['id' => $item->id, 'label' => $item->label]);
    }
}

