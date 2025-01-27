<?php

namespace App\Models\DMaster;

use Illuminate\Database\Eloquent\Model;

class ChannelMarketingModel extends Model {    
	/**
	 * nama tabel model ini.
	 *
	 * @var string
	 */
	protected $table = 'pe3_channel_marketing';
	/**
	 * primary key tabel ini.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 
    'namachannel',     
	];
	/**
	 * enable auto_increment.
	 *
	 * @var string
	 */
	public $incrementing = false;
	/**
	 * activated timestamps.
	 *
	 * @var string
	 */
	public $timestamps = true;
}