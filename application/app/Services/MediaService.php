<?php

namespace App\Services;

use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * @var MediaRepository
     */
    protected MediaRepository $mediaRepository;

    /**
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Select all companies
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->mediaRepository->getAllMedias($paginate);
    }

    /**
     * Filter companies
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->mediaRepository->getFilteredMedias($filters, $paginate);
    }

    public function filterMediaFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->mediaRepository->filterMediaFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->mediaRepository->getMediaFields();
    }

    /**
     * Select a media by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->mediaRepository->getMediaById($id);
    }

    /**
     * Create a new Media
     * @param array $data
     * @return object
     */
    public function saveMediaData(array $data)
    {
        if ($data['id'] == 'new') {
            try {
                $validator = Validator::make($data, [
                    'media' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                if ($validator->fails()) {
                    throw new \InvalidArgumentException($validator->errors()->first());
                }
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        DB::beginTransaction();

        try {
            $uuid = Str::uuid();
            // Move the uploaded file to the storage path
            $file_path = Storage::putFileAs('public/images', $data['media'], $uuid . '.' . $data['media']->getClientOriginalExtension());

            $data['uuid'] = $uuid;
            $data['file_location'] = str_replace('public/', '', $file_path);
            $data['file_name'] = $data['media']->getClientOriginalName();
            $data['file_format'] = $data['media']->getClientOriginalExtension();
            $data['entities_type'] = 'media';
            $data = array_filter($data);

            $media = $this->mediaRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update media data');
        }

        DB::commit();

        return $media;
    }

    /**
     * Delete a Media
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $media = $this->mediaRepository->destroyMedia($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete media');
        }
        try {
            DB::commit();
        } catch (\Throwable $th) {
            dd('services =>', $th);
        }

        return $media;
    }
}