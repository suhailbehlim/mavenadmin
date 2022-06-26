<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDescription extends Model
{
    use HasFactory;

    protected $table = "CourseDescription";

    protected $fillable = [
        'courseID', 'courseFeatures','whatWeLearn','courseDetails','whatWeLearnImage','courseDetailsImage','courseDetailsFaq', 'course_features_list', 'admission_process_type','admission_process_subtitle', 'scholarship','fees','faq','placement', 'placementImage'
    ];

    public $timestamps = false;

public function getFaqAttribute($value)
{
    return unserialize($value);
   
}
public function CourseFeatures()
{
    return $this->hasMany(CourseDescriptionFeatures::class, 'courseID','courseID')->orderBy('Order','DESC');
}
public function AdmissionProcess()
{
    return $this->hasMany(AdmissionProcess::class, 'courseID','courseID')->orderBy('Order','DESC');
}
public function ScholarshipScheme()
{
    return $this->hasMany(ScholarshipScheme::class, 'courseID','courseID')->orderBy('Order','DESC');
}
public function BatchCalendar()
{
    return $this->hasMany(BatchCalendar::class, 'courseID','courseID')->orderBy('Order','DESC');
}
public function WinningDifference()
{
    return $this->hasMany(WinningDifference::class, 'courseID','courseID')->orderBy('Order','DESC');
}

}
