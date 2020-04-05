<?php

namespace App\Helper;
use App\Models\ClaimBilling;
use App\Models\KpiData;
use DB;
class Kpicron
{
   
    public function kpiCron()
    {
        $agencyDetails = ClaimBilling::distinct()->select('agency_id')->get();
        
        $month = date('m');
        $year  = date('Y');
        
        if(!empty($agencyDetails)){
            foreach($agencyDetails as $key => $agency){  
                $agencyId = $agency->agency_id;
                $employeeActivities = $this->getEmployeeActivities($agencyId, $month, $year);
                $financeDetails = $this->getFinanceDetails($agencyId, $month, $year);
        
                $census = $employeeActivities[0]->census ?? 0;
                $charges = $financeDetails[0]->charges ?? 0;
                $visits =  $employeeActivities[0]->visits ?? 0;
                $received_amount = $financeDetails[0]->received_amount;
                
                $row = KpiData::updateOrCreate(['year'=> $year, 'month'=> $month, 'agency_id'=> $agencyId],
                ['year'=> $year, 'month'=> $month, 'agency_id'=> $agencyId,
                 'census'=> $census, 'visits' => $visits, 'charges'=> $charges, 'received'=> $received_amount,
                 'ar_balance' => ($charges - $received_amount), 'avg_rev_per_customer'=> ($charges / (($census == 0) ? 1 : $census)),
                 'avg_per_visits' => ( $charges / (($visits == 0) ? 1 : $visits))
                ]);
                         
            }
        
        }  
    }

    /**
     * get the details of employee activities.
     *
     * @param  int  $agencyId
     * @param  int  $month
     * @param  int  $year
     */

    function getEmployeeActivities($agencyId, $month, $year)
    {
        $employeeActivities = DB::select("SELECT 
            count(DISTINCT(CASE MONTH(ea.clockin) WHEN $month THEN ea.Job_code else 0 END)) AS 'census',
            count(DISTINCT(CASE MONTH(ea.clockin) WHEN $month THEN ea.id else 0 END)) AS 'visits'
            FROM  employee_activities ea inner join agency_jobs aj on ea.Job_code = aj.job_code 
            where YEAR(ea.clockin) = $year AND MONTH(ea.clockin) = $month AND  aj.agency_id = $agencyId");

        return $employeeActivities;
    }

    /**
     * get the details of finance details.
     *
     * @param  int  $agencyId
     * @param  int  $month
     * @param  int  $year
     */
    function getFinanceDetails($agencyId, $month, $year)
    {
        $financeDetails = DB::select("SELECT
             SUM(CASE MONTH(created_at) WHEN $month THEN amount else 0 END) AS 'charges',
             SUM(CASE MONTH(created_at) WHEN $month THEN receivable_amount else 0 END) AS 'received_amount'
             FROM  claim_billing where YEAR(created_at) = $year AND MONTH(created_at) = $month AND agency_id = $agencyId");

        return $financeDetails;     
    }

}