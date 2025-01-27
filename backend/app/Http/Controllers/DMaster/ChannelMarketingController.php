<?php

namespace App\Http\Controllers\DMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\DMaster\ChannelMarketingModel;

use Ramsey\Uuid\Uuid;
class ChannelMarketingController extends Controller 
{  
  /**
   * daftar channel marketing
   */
  public function index(Request $request)
  {
    $this->hasPermissionTo('DMASTER-CHANNEL-MARKETING_BROWSE');
    
    $channel = ChannelMarketingModel::all();

    return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',  
      'channelmarketing' => $channel,
      'message' => 'Fetch data channel marketing berhasil.'
    ], 200);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->hasPermissionTo('DMASTER-CHANNEL-MARKETING_STORE');

    $rule = [            
      'namachannel' => 'required|string|unique:pe3_channel_marketing,namachannel',      
    ];
  
    $this->validate($request, $rule);
       
    $channel = ChannelMarketingModel::create([
      'id'=>Uuid::uuid4()->toString(),
      'namachannel' => strtoupper($request->input('namachannel')),      
    ]);                 
    
    \App\Models\System\ActivityLog::log($request,[
      'object' => $channel,
      'object_id' => $channel->id, 
      'user_id' => $this->getUserid(), 
      'message' => 'Menambah channel marketing baru berhasil'
    ]);

    return Response()->json([
      'status' => 1,
      'pid' => 'store',
      'channelmarketing' => $channel,    
      'message' => 'Data channel marketing berhasil disimpan.'
    ], 200); 

  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->hasPermissionTo('DMASTER-CHANNEL-MARKETING_UPDATE');

    $channel = ChannelMarketingModel::find($id);
    if (is_null($channel))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'update',    
        'message' => ["Channel Marketing ($id) gagal diupdate"]
      ], 422); 
    }
    else
    {
      $this->validate($request, [
        'namachannel' => [
          'required',            
          'string',                
          Rule::unique('pe3_channel_marketing')->ignore($channel->namachannel, 'namachannel')           
        ],                      
      ]); 
    
      $channel->namachannel = strtoupper($request->input('namachannel'));     
            
      $channel->save();

      \App\Models\System\ActivityLog::log($request,[
        'object' => $channel,
        'object_id' => $channel->id, 
        'user_id' => $this->getUserid(), 
        'message' => 'Mengubah data channel marketing (' . $channel->namachannel . ') berhasil'
      ]);

      return Response()->json([
        'status' => 1,
        'pid' => 'update',
        'channelmarketing' => $channel,      
        'message' => 'Data channel marketing ' . $channel->namachannel . ' berhasil diubah.'
      ], 200); 
    }
  }    
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request,$id)
  { 
    $this->hasPermissionTo('DMASTER-CHANNEL-MARKETING_DESTROY');

    $channel = ChannelMarketingModel::find($id); 
    
    if (is_null($channel))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'destroy',    
        'message' => ["Channel marketing dengan id ($id) gagal dihapus"]
      ], 422); 
    }
    else
    {
      \App\Models\System\ActivityLog::log($request,[
        'object' => $channel, 
        'object_id' => $channel->id, 
        'user_id' => $this->getUserid(), 
        'message' => 'Menghapus Channel marketing (' . $id. ') berhasil'
      ]);
      $channel->delete();
      return Response()->json([
        'status' => 1,
        'pid' => 'destroy',    
        'message' => "Channel marketing dengan kode ($id) berhasil dihapus"
      ], 200);    
    }     
  }
}