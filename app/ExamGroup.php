<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamGroup extends Model
{
    /**
     * One Exam Group has many examGroupExam
     * exam_group_exam is a pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examGroupExams(){
        return $this->hasMany('App\ExamGroupExam','exam_group_id','íd');
    }

    /**
     *One exam group has zero or many parentExamGroup for this
     * for e.g. we can include (first term exam) result in the (final term exam)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentExamGroupExams(){
        return $this->hasMany('App\ExamGroupExam','parent_exam_group_id','id');
    }

    /**
     * One exam group has many exams
     * for e.g. first term exam has many subjects exam included in it
     * first term exam can include the exams of the different subjects i.e. english, math, etc
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams(){
        return $this->belongsToMany('App\Exam','exam_group_exam','parent_exam_group_id','exam_id');
    }

    /**
     * One exam Group can have one or many parent Exam groups
     * i.e a subject's unit test can be included in the final term exam group
     * as well as in the first term exam group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parentExamGroups(){
        return $this->belongsToMany('App\ExamGroup','exam_group_exam','parent_exam_group_id','exam_group_id');
    }

    /**
     * This method is for the parent Exam group
     * find the exam groups of this parent exam group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function examGroups(){
        return $this->belongsToMany('App\ExamGroup','exam_group_exam','parent_exam_group_id','exam_group_id');
    }

    /**
     * A exam group belongs to a school session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\schoolSession','school_session_id','id');
    }

}
