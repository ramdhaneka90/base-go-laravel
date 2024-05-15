<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

trait BuilderTrait
{
    public function scopeTransaction($query, $callback)
    {
        DB::beginTransaction();

        $result = $callback();

        if ($result['code'] == 200)
        {
            DB::commit();
        }
        else
        {
            DB::rollback();
        }

        return $result;
    }

    public function scopeData($query, $key = NULL, $orderBy = NULL, $direction = 'asc', $offset = 0, $limit = 0)
    {
        if (is_array($key)) {
          $key_temp = $key;
          // usage ['column'=>['value','value']] convert to whereIn
          foreach($key_temp as $k => $v){
            if(is_array($v)){
              $query->whereIn($k,$v);
              unset($key[$k]);
            }
          }
          //end
          $query->where($key);
        }

        if (!empty($offset) || !empty($limit)) {
            $query->take($limit)->skip($offset);
        }

        if (!empty($orderBy)) {
            $query->orderBy($orderBy, $direction);
        }

        return $query;
    }

    public function scopeWhereLike($query, $name, $value, $status = 'both')
    {
        switch ($status) {
            case 'left':
                $value = $value . '%';
                break;
            case 'right':
                $value = '%' . $value;
                break;
            case 'both':
                $value = '%' . $value . '%';
                break;
        }

        $query->where($name, 'ilike', $value);
        return $query;
    }

    public function scopeCreateOne($query, array $data, $callback = NULL)
    {
        try {
            $event = $query->create($data);

            // if contain callback
            if (is_callable($callback)) {
                $callback($query, $event);
            }

            $event->id = encrypt($event->id);

            return [
                'code'    => 200,
                'status'  => 'success',
                'message' => __('Simpan data berhasil'),
                'data'    => $event,
            ];
        } catch (Exception $e) {
            return [
                'code'    => 400,
                'status'  => 'error',
                'message' => __('Simpan data gagal'),
                'data'    => $e->getMessage()
            ];
        }
    }

    public function scopeUpdateOne($query, $id, array $data, $callback = NULL)
    {
        try {
            $cursor = $query->find($id);
            if ($cursor) {
                $event = $cursor->update($data);

                // if contain callback
                if (is_callable($callback)) {
                    $callback($query, $event, $cursor);
                }

                $cursor->id = encrypt($cursor->id);

                return  [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => __('Proses edit berhasil.'),
                    'data'    => $cursor
                ];
            } else {
                return  [
                    'code'    => 400,
                    'status'  => 'error',
                    'message' => __('ID tidak ditemukan.')
                ];
            }
        } catch (Exception $e) {
            return [
                'code'    => 400,
                'status'  => 'error',
                'message' => __('Proses edit gagal.'),
                'data'    => $e->getMessage()
            ];
        }
    }

    public function scopeDeleteOne($query, $id, $callback = NULL)
    {
        try {
            $cursor = $query->find($id);
            if ($cursor) {
                $event = $cursor->delete();

                // if contain callback
                if (is_callable($callback)) {
                    $callback($query, $event, $cursor);
                }

                return  [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => __('Proses hapus berhasil.'),
                    'data'    => [
                        'id' => encrypt($id),
                    ]
                ];
            } else {
                return  [
                    'code'    => 400,
                    'status'  => 'error',
                    'message' => __('ID tidak ditemukan.')
                ];
            }
        } catch (Exception $e) {
            return [
                'code'    => 400,
                'status'  => 'error',
                'message' => __('Proses delele gagal.'),
                'data'    => $e->getMessage()
            ];
        }
    }

    public function scopeDeleteBatch($query, array $id, $callback = NULL)
    {
        try {
            $cursors = $query->whereIn('id', $id)->get();
            if ($cursors) {
                $deleted_id = [];

                foreach ($cursors as $cursor) {
                    $deleted_id[] = encrypt($cursor->id);
                    $event = $cursor->delete();

                    // if contain callback
                    if (is_callable($callback)) {
                        $callback($query, $event, $cursor);
                    }

                }

                return  [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => __('Proses hapus berhasil.'),
                    'data'    => [
                        'id' => encrypt($id),
                    ]
                ];
            } else {
                return  [
                    'code'    => 400,
                    'status'  => 'error',
                    'message' => __('ID tidak ditemukan.')
                ];
            }
        } catch (Exception $e) {
            return [
                'code'    => 400,
                'status'  => 'error',
                'message' => __('Proses delele gagal.'),
                'data'    => $e->getMessage()
            ];
        }
    }

    public function scopeIsActive($query)
    {
        $query->where('status', 1);
        return $query;
    }
}
