<?php

namespace App\Services;

use App\Models\Checklist;
use App\Repositories\ChecklistRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ChecklistService
{
    /**
     * @var $checklistRepository
     */
    protected $checklistRepository;

    /**
     * ChecklistService constructor.
     *
     * @param ChecklistRepository $checklistRepository
     */
    public function __construct(ChecklistRepository $checklistRepository)
    {
        $this->checklistRepository = $checklistRepository;
    }

    /**
     * Delete checklist by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $checklist = $this->checklistRepository->delete($id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete checklist data');
        }

        DB::commit();

        return $checklist;

    }

    /**
     * Get all checklist.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->checklistRepository->getAll();
    }

    /**
     * Get checklist by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->checklistRepository->getById($id);
    }

    /**
     * Update checklist data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateChecklist($data, $id)
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
            $checklist = $this->checklistRepository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update checklist data');
        }

        DB::commit();

        return $checklist;

    }

    /**
     * Validate checklist data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveChecklistData($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->checklistRepository->save($data);

        return $result;
    }

}
