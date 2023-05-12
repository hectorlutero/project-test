<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class MediaRepository
{
    /**
     * @var File
     */
    protected $media;

    /**
     * MediaRepository constructor
     * @param File $media
     */
    public function __construct(File $media)
    {
        $this->media = $media;
    }

    /**
     * Get all Medias
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllMedias($paginate)
    {
        return $this->media->with('user')->paginate($paginate);
    }

    public function filterMediaFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->media->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredMedias($filterParams, $paginate)
    {
        $filtered = $this->media->query();
        if (empty($filterParams['term']))
            return $filtered->paginate($paginate);
        $fields = $this->getSearchableFields();
        foreach ($fields as $key => $field) {
            $filtered->orWhere($field, 'LIKE', "%" . $filterParams['term'] . "%");
        }

        return $filtered->orderBy('id')->paginate($paginate);

    }

    public function getSearchableFields()
    {
        return [
            "name",
            "slug",
            "document",
            "description",
            "location",
            "zip_code",
            "state",
            "country",
            "phone",
            "email",
            "website",
            "facebook",
            "twitter",
            "linkedin",
            "pinterest",
            "youtube",
            "instagram",
        ];
    }

    public function getMediaFields()
    {

        $fields = [
            "user_id" => "select:users",
            "media_category_id" => "select:media_categories",
            "plan_id" => "select:plans",
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "document" => "input:text|mask:99.999.999/9999-99",
            "description" => "input:text",
            "location" => "input:text",
            "zip_code" => "input:text|mask:99.999-999",
            "state" => "input:text",
            "country" => "input:text",
            "phone" => "input:text|mask:99 99999-9999",
            "email" => "input:text",
            "website" => "input:text",
            "facebook" => "input:text",
            "twitter" => "input:text",
            "linkedin" => "input:text",
            "pinterest" => "input:text",
            "youtube" => "input:text",
            "instagram" => "input:text",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Media by ID
     * @param int $id
     * @return object
     */
    public function getMediaById(int $id)
    {
        return $this->media->where('id', $id)->first();
    }

    /**
     * Create a new Media
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {
            $data['entities_id'] = $data['id'];
            unset($data['id']);
            unset($data['media']);
            // dd($data);
            try {
                $entry = $this->media->create($data);
            } catch (\Throwable $th) {
                dd($th);
            }
        } else {
            $entry = $this->media->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry))
                $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a media
     * @param int $id
     */
    public function destroyMedia(int $id)
    {
        $media = $this->media->find($id);
        try {
            Storage::delete("/images/$media->file_location");
            $media->delete();
        } catch (\Throwable $th) {
            dd('repository => ', $th);
            //throw $th;
        }

        return $media;
    }
}