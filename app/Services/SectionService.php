<?php

namespace App\Services;

use App\Models\Section;
use App\Repositories\SectionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class SectionService
{
    /**
     * @var $sectionRepository
     */
    protected $sectionRepository;

    /**
     * SectionService constructor.
     *
     * @param SectionRepository $sectionRepository
     */
    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * Delete section by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $section = $this->sectionRepository->delete($id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete section data');
        }

        DB::commit();

        return $section;

    }

    /**
     * Get all section.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->sectionRepository->getAll();
    }

    /**
     * Get section by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->sectionRepository->getById($id);
    }

    /**
     * Update section data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateSection($data, $id)
    {
        $validator = Validator::make($data, [
            'title' => 'bail|min:2',
            'description' => 'bail|max:255'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $section = $this->sectionRepository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update section data');
        }

        DB::commit();

        return $section;

    }

    /**
     * Validate section data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveSectionData($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->sectionRepository->save($data);

        return $result;
    }

}
