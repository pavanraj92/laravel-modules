<?php

namespace Modules\Seo\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Seo\App\Http\Requests\SeoMetaCreateRequest;
use Modules\Seo\App\Http\Requests\SeoMetaUpdateRequest;
use Modules\Seo\App\Models\SeoMeta;

class SeoManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admincan_permission:seo_manager_list')->only(['index']);        
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $seoMetas = SeoMeta::filter($request->query('keyword'))
                ->filterByModel($request->query('model_name'))
                ->sortable()
                ->paginate(SeoMeta::getPerPageLimit())
                ->withQueryString();

            $modelOptions = SeoMeta::getModelOptions();

            return view('seo::admin.index', compact('seoMetas', 'modelOptions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load SEO meta: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeoMetaCreateRequest $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoMeta $seoMeta)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeoMeta $seoMeta)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeoMetaUpdateRequest $request, SeoMeta $seoMeta)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoMeta $seoMeta)
    {
        
    }
}
