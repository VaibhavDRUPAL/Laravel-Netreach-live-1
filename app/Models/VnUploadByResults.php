<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VnUploadByResults extends Model
{
	//
	protected $table = 'vn_upload_survey_files';
	protected $fillable = ['created_by', 'acess_date', 'pid', 'detail', 'file_upload', 'outcome', 'dontshare'];
}
