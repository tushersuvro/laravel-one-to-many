<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //
    public function index() {
        $doctors = Doctor::with('prescriptions')->get();
        dd($doctors);
    }

    public function create() {

        $prescriptions = [
            [
                'medicine' => 'Paracetamol',
                'test' => 'Blood test',
                'potential_diagnosis' => 'Cold'
            ],
            [
                'medicine' => 'Aspirin',
                'test' => 'Blood test',
                'potential_diagnosis' => 'Cold'
            ]
        ];

        $doctor = Doctor::create(['name' => 'Dr. John Smith']);

        $doctor->prescriptions()->createMany($prescriptions);

        return redirect('doctors');
    }

    public function edit(Doctor $doctor) {

        $doctor->load('prescriptions');

        $updatedPrescriptions = [
            [
                'medicine' => 'Paracetamol 2',
                'test' => 'Blood test 2',
                'potential_diagnosis' => 'Cold'
            ],
            [
                'medicine' => 'Aspirin 2',
                'test' => 'Blood test 2',
                'potential_diagnosis' => 'Cold'
            ]
        ];

        $doctor->update(['name' => 'Dr. John Smith Doe']);

        $i = 0;
        // accessing a relationship $doctor->prescriptions instead of Calling a method $doctor->prescriptions()
        foreach ( $doctor->prescriptions as $prescription) {
            // Handling the case where the number of prescriptions is less than $updatedPrescriptions
            // $doctor->prescriptions may not be the same as the number of elements in $updatedPrescriptions.
            if ($i < count($updatedPrescriptions)) {
                $prescription->update($updatedPrescriptions[$i]);
                $i++;
            } else {
                break;
            }
        }
        return redirect('doctors');
    }

    public function delete(Doctor $doctor) {
        $doctor->load('prescriptions');

        if( $doctor->prescriptions->isNotEmpty() ) {
            $doctor->prescriptions->each->delete();
        }
        $doctor->delete();
        return redirect('doctors');
    }
}
