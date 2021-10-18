<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Resources\CampaignResource;
use App\Http\Requests\CampaignStoreRequest;
use App\Exceptions\CreativeUploadFailedException;

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
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignStoreRequest $request)
    {
        $campaign = Campaign::create([
            'name' => $request->name,
            'daily_budget' => $request->daily_budget * 100, //  Multiply amount by 100, the PHP money package calculates money in cents.
            'total_budget' => $request->total_budget * 100,
            'from' => $request->from,
            'to' => $request->to
        ]);

        $this->uploadCreativeImages($campaign, $request);

        return response()->json(201);
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
    }

    private function uploadCreativeImages(Campaign $campaign, CampaignStoreRequest $request)
    {
        try {
            $creatives = $request->file('creatives');
            foreach ($creatives as $creative) {
                $basePath = '/images/creatives/' . md5(microtime()) . '.' . $creative->getClientOriginalExtension();
                $creativePath = public_path() . $basePath;
                $newImage = Image::make($creative);
                $newImage->save($creativePath);

                $campaign->creatives()->create(['path' => config('app.url')  . $basePath]);
            }
        } catch (Exception $e) {
            throw $e; //new CreativeUploadFailedException("Failed to upload creative image.");
        }
    }
}
