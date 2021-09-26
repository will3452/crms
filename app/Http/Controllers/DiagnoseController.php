<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Symptom;
use App\Models\UserDiagnosis;

class DiagnoseController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::get();
        return view('diagnoses', compact('symptoms'));
    }

    public function getResults()
    {
        return view('diagnoses-results',
            [
                'results' => auth()->user()->diagnoses()->latest()->get()
            ]);
    }

    public function process()
    {
        $data = request()->validate([
            'symptoms' => 'required',
        ]);

        $symptoms = Symptom::find($data['symptoms']);
        $diagnosesId = [];

        $diagnoses = Diagnosis::with(['symptoms', 'medicines'])->get();
        $result = [];
        foreach ($diagnoses as $diagnosis) {
            $flag = true;
            foreach ($symptoms as $s) {
                $d = $diagnosis->symptoms->pluck('id');

                if (!$d->contains($s->id)) {
                    $flag = false;
                }
            }

            if ($flag) {
                $result[] = $diagnosis;
                $diagnosesId[] = $diagnosis->id;
            }
        }

        foreach ($diagnosesId as $id) {
            UserDiagnosis::create([
                'user_id' => auth()->id(),
                'diagnosis_id' => $id,
            ]);
        }

        return view('diagnoses-result', ['symtomps' => $symptoms, 'diagnoses' => $result]);
    }
}
