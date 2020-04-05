<?php

namespace App\Helper;
use App\Models\JobShifts;
use App\Models\EmployeeActivites;
use Carbon\Carbon;
class VisitHelper
{
   
    public function runCron()
    {
      
      $date = Carbon::now();
      $startOfWeek = $date->startOfWeek()->format('Y-m-d H:i:s');
      $endOfWeek = $date->endOfWeek()->format('Y-m-d H:i:s');

      $jobShifts = JobShifts::where('ref_in_at','>=',$startOfWeek)->where('ref_in_at','<=',$endOfWeek)->get(['ref_in_at','ref_out_at','agency_id','id','job_id','visit_id','agency_id']);
     
      foreach($jobShifts as $row){
          
          $activities = EmployeeActivites::where('clockin','>=',$row->ref_in_at)
                                          ->where('clockout','<=',$row->ref_out_at)
                                          ->where('Job_code',$row->job_id)
                                          ->get(['clockin','clockout','Job_code','id','agency_id']);
                                          
          $ref_in_at = date('Y-m-d H:i:s',strtotime('-1 hour',strtotime($row->ref_in_at)));
          $ref_out_at = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($row->ref_out_at)));                               
          
          $jobAgencyId = $row->agency_id;
          foreach($activities as $aRow){
              $clockIn = $aRow->clockin;
              $clockOut = $aRow->clockout;
              $jobCode = $aRow->Job_code;
              $id = $aRow->id;
              $visitAgencyId = $aRow->agency_id;

              if(($jobAgencyId == $visitAgencyId) && ($jobCode == $row->job_id) && ($clockIn >= $ref_in_at && $ref_out_at >= $clockOut)){
                  $row->visit_id = $id;
                  $row->save();
              }  
          }
      }
    }

}