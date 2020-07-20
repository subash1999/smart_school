<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * One exam belongs to the a gradeSubject pivot table
     * One exam belongs to a subject of a grade
     * This is a belongs to relation to the pivot table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gradeSubject(){
        return $this->belongsTo('App\GradeSubject','grade_subject_id','id');
    }

    /**
     * One exam has many  parent in examGroupExam pivot table
     * One exam can have many parent exam group(First term, Second term) which is stored in exam_group_exam pivot table
     * This is a belongs to relation to the pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentExamGroupExams(){
        return $this->hasMany('App\ExamGroupExam','parent_exam_group_id','id');
    }

    /**
     * one exam belongs to many parent exam group
     * one exam can be included in many exam groups
     * i.e An exam can be included in monthly exam group as well as in final term exam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parentExamGroup(){
        return $this->belongsToMany('App\ExamGroup','exam_group_exam','exam_id','parent_exam_group_id');
    }

    /**
     * One exam has many marks for each students
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks(){
        return $this->hasMany('App\Mark','mark_id','id');
    }


}
