<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Services\SectionService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponse;
    
    /**
     * @var sectionService
     */
    protected $sectionService;

    /**
     * SectionController Constructor
     *
     * @param SectionService $sectionService
     *
     */
    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function test() {
        return "ok";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = $this->sectionService->getAll();
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        return $this->sendData($result);
    }

    /**
     * Display a listing of the resource with its checklists.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllWithChecklist()
    {
        try {
            $result = $this->sectionService->getAllWithChecklist();
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        return $this->sendData($result);
    }

    /**
     * Display a listing of the resource with its checklists.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByIdWithChecklist($id)
    {
        try {
            $result = $this->sectionService->getByIdWithChecklist($id);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }

        return $this->sendData($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->sectionService->saveSectionData($data);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        return $this->sendCreated($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = $this->sectionService->getById($id);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }
        
        return $this->sendData($result);
    }

    /**
     * Update section.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSectionRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $result = $this->sectionService->updateSection($data, $id);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }

        return $this->sendUpdated($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->sectionService->deleteById($id);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }

        return $this->sendDeleted($result);
    }
}
