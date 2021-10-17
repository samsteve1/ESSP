<?php

namespace App\Http\Controllers;

use Image;
use App\Http\Requests\CampaignStoreRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use CreativeUploadFailedException;
use Exception;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return response()->json(CampaignResource::collection($campaigns), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignStoreRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $campaign = Campaign::create([
            'name' => $request->name,
            'daily_budget' => $request->daily_budget,
            'total_budget' => $request->total_budget,
            'from' => $request->from,
            'to' => $request->to
        ]);

        $this->uploadCreativeImages($campaign, $request);

        return response()->json(201);
    }

    private function uploadCreativeImages(Campaign $campaign, CampaignStoreRequest $request)
    {
        try {
            $creatives = $request->file('creatives');
            foreach ($creatives as $creative) {
                $basePath = '/images/creatives' . microtime() . '.' . $creative->getClientOriginalExtension();
                $creativePath = public_path() . $basePath;
                $newImage = Image::make($creative);
                $newImage->save($creativePath);

                $campaign->creatives()->create(['path' => $creativePath]);
            }
        } catch (Exception) {
            throw new CreativeUploadFailedException("Failed to upload creative image.");
        }
    }
}
