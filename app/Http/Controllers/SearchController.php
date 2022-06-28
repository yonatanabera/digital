<?php

namespace App\Http\Controllers;



use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Medication;
use App\Models\Pharmacy;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class searchController extends Controller

{
    //Searched by medication and returns pharmacy. 
    public function searchByMedication($medication)
    {
        // $med= Medication::where('name','like',"%{$medication}%")->first()->pharmacies()->get();

        $med = Medication::where('name', 'like', "%{$medication}%")->with("pharmacies")->first();

        return $med;
    }
    // public function searchByMedications($medication){        
    //     // $med= Medication::where('name','like',"%{$medication}%")->first()->pharmacies()->get();

    //     $med= Medication::where('name','like',"%{$medication}%")->with("pharmacies")->get();

    //     return $med; 
      
    // }

    public function searchByMedications($medication)
    {
        // $med= Medication::where('name','like',"%{$medication}%")->first()->pharmacies()->get();

        // return Medication::orderByRaw("RAND()")->get();

        // $med = Medication::where('name', 'like', "%{$medication}%")->orderByRaw("RAND()")->with("pharmacies")->get();

        $med = Medication::where('name', 'like', "%{$medication}%")->with("pharmacies")->get();

        return $med;
    }

    public function searchByPharmacy($req)
    {
        $pharmacy =  urldecode($req);

        $response1 = Pharmacy::where('name', 'like', "%{$pharmacy}%")->get();
        $response2 = Medication::where('name', 'like', "%{$pharmacy}%")->with("pharmacies")->get();
        $array = [];
        foreach ($response1 as $pharmacy) {
            // array_push($array,$pharmacy);
            $array[$pharmacy->id] = $pharmacy;
        }
        foreach ($response2 as $medication) {
            foreach ($medication->pharmacies as $pharm) {
                // array_push($array,$pharm);
                $array[$pharm->id] = $pharm;
            }
            // array_push($array,$medication);
        }
        return array_values(array_unique($array));
    }

    public function searchByProcedures($procedure)
    {
        // return $procedure;
        $response1 = Diagnostic::where('name', 'like', "%{$procedure}%")->get();

        $response2 = Procedure::where('name', 'like', "%{$procedure}%")->with("diagnostics")->get();

        // return $response2;

        $response = [
            "Diagnostics" => $response1,
            "Procedures" => $response2
        ];


        return $response;
    }

    public function searchByDiagnostics($req)
    {
        $diagnostics =  urldecode($req);

        $response1 = Diagnostic::where('name', 'like', "%{$diagnostics}%")->get();

        $response2 = Procedure::where('name', 'like', "%{$diagnostics}%")->with("diagnostics")->get();
        // return $response1;
        $array = [];
        foreach ($response1 as $diagnostics) {
            // array_push($array,$diagnostics);
            $array[$diagnostics->id] = $diagnostics;
        }
        foreach ($response2 as $procedure) {
            foreach ($procedure->diagnostics as $diag) {
                // array_push($array,$diag);
                $array[$diag->id] = $diag;
            }
        }
        return array_values(array_unique($array));
    }

    public function searchByDiagnosticsTG($req)
    {
        $diagnostics =  urldecode($req);

        $response2 = Procedure::where('name', 'like', "%{$diagnostics}%")->with("diagnostics")->get();
        return $response2;
    }

    public function searchByHospital($req)
    {
        $hospital =  urldecode($req);
        $response1 = Doctor::where('speciality', 'like', "%{$hospital}%")->orWhere('expertise', 'like', "%{$hospital}%")->with("hospitals")->get();
        $response2 = Hospital::where('name', 'like', "%{$hospital}%")->get();
        $array = [];
        foreach ($response2 as $hospital) {
            // array_push($array,$hospital);
            $array[$hospital->id] = $hospital;
        }
        foreach ($response1 as $doctor) {
            foreach ($doctor->hospitals as $doc) {
                // array_push($array,$doc);
                $array[$doc->id] = $doc;
            }
        }
        return array_values(array_unique($array));
    }

    public function searchByDoctor($req)
    {
        $doctor =  urldecode($req);

        $doctor = addslashes($doctor);
        return Doctor::where('name', 'like', "%{$doctor}%")->orWhere('speciality', 'like', "%{$doctor}%")->orWhere('expertise', 'like', "%{$doctor}%")->with("hospitals")->get();
    }
}


