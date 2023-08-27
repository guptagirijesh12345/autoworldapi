<?php
  use App\Models\working_day;
if (!function_exists('getErrorAsString')) {
    function getErrorAsString($messagearr)
    {
        $message = '';
        if (is_string($messagearr)) {
            return $messagearr;
        }
        $totalmsg = $messagearr->count();
        
        foreach ($messagearr->all() as $key => $value) {

            $message .= $key < $totalmsg - 1 ? $value . '/' : $value;

        }
        return $message;
    }
}
 
if (!function_exists('workingday')) {
      function workingday($id)
      {
         for($i =1;$i<=7;$i++)
         {   
            $data = New working_day();
            $data->user_id  =  $id;
            $data->day_id   = $i;
            $data->save();
         }
            
      }
}


?>