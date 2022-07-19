<?php

namespace App\Repositories;

use App\Models\Section;
use App\Traits\ApiResponse;

class SectionRepository
{
    use ApiResponse;
    /**
     * @var Section
     */
    protected $section;

    /**
     * SectionRepository constructor.
     *
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * Get all sections.
     *
     * @return Section $section
     */
    public function getAll($userId)
    {
        return $this->section
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Get all sections with its checklists.
     *
     * @return Section $section
     */
    public function getAllWithChecklist($userId)
    {
        return $this->section
            ->with('checklist')
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Get all sections with its checklists.
     *
     * @return Section $section
     */
    public function getByIdWithChecklist($userId, $id)
    {
        $sections = $this->section
            ->with('checklist')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->get();

        if ($sections->isEmpty()) {
            return null;
        }

        return $sections;
    }

    /**
     * Get section by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($userId, $id)
    {
        $section = $this->section
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
        
        if (!$section) {
            return null;
        }

        return $section;
    }

    /**
     * Save Section
     *
     * @param $data
     * @return Section
     */
    public function save($data)
    {
        $section = new $this->section;
        $section = $section->create($data);

        return $section->fresh();
    }

    /**
     * Update Section
     *
     * @param $data
     * @return Section
     */
    public function update($data, $id)
    {
        $section = $this->section
                ->where('id', $id)
                ->first();

        if (!$section) {
            return null;
        }
        
        $section->update($data);

        return $section;
    }

    /**
     * Update Section
     *
     * @param $data
     * @return Section
     */
    public function delete($userId, $id)
    {
        $section = $this->section
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$section) {
            return null;
        }

        $section->delete();

        return $section;
    }

}
