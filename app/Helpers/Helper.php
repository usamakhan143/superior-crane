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

    public static function addFile($fileUrl, $file_type, $file_ext_type, $jobId, $userId, $riggerId, $transportationId, $paydutyId)
    {
        $add_file = new File();
        $add_file->file_url = $fileUrl; // File URL
        $add_file->base_url = url('') . '/'; // This the global baseUrl of the application. file is uploaded by this URL.
        $add_file->file_type = $file_type; // job-gallery, rigger-gallery, signature, riggerpayduty-pdf, transportation-gallery
        $add_file->file_ext_type = $file_ext_type; // pdf / image
        $add_file->job_id = $jobId ?? 0;
        $add_file->account_id = $userId;
        $add_file->rigger_id = $riggerId ?? 0;
        $add_file->transportation_id = $transportationId ?? 0;
        $add_file->payduty_id = $paydutyId ?? 0;

        $Save = $add_file->save();
        return [
            'isSave' => $Save,
            'data' => $add_file
        ];
    }
}
