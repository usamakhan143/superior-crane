<?php

namespace App\Helpers;

use App\Models\Apis\File;

class Helper
{
    public static function getRoles()
    {
        $roles = [
            'a' => 'admin',
            'sa' => 'super_admin',
            'm' => 'manager',
            'bu' => 'user',
        ];

        return $roles;
    }

    public function addFile($imageFile, $file_type, $file_ext_type, $jobId, $userId, $riggerId, $transportationId, $paydutyId) {
        $add_file = new File();
        $add_file->file_url = $imageFile;
        $add_file->base_url = url('') . '/';
        $add_file->file_type = $file_type;
        $add_file->file_ext_type = $file_ext_type;
        $add_file->job_id = $jobId;
        $add_file->account_id = $userId;
        $add_file->rigger_id = $riggerId;
        $add_file->transportation_id = $transportationId;
        $add_file->payduty_id = $paydutyId;

        $add_file->save();
    }
}
