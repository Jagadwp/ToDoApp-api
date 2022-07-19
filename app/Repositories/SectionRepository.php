<?php

namespace App\Repositories;

use App\Models\Section;

class SectionRepository
{
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
    public function getAll()
    {
        return $this->section
            ->get();
    }

    /**
     * Get section by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->section
            ->where('id', $id)
            ->get();
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

        $section->title = $data['title'];
        $section->description = $data['description'];

        $section->save();

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
        
        $section = $this->section->find($id);

        $section->title = $data['title'];
        $section->description = $data['description'];

        $section->update();

        return $section;
    }

    /**
     * Update Section
     *
     * @param $data
     * @return Section
     */
    public function delete($id)
    {
        
        $section = $this->section->find($id);
        $section->delete();

        return $section;
    }

}
