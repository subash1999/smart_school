<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamGroupExam extends Model
{
    protected $table = "exam_group_exam";

    /**
     * Get the parent exam group of ExamGroupExam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentExamGroup(){
        return $this->belongsTo('App\ExamGroup','parent_exam_group_id','id');
    }

    /**
     * Get the exam group of the ExamGroupExam     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examGroup(){
        return $this->belongsTo('App\ExamGroup','exam_group_id','id');
    }

    /**
     * Get the exam that belongs to the ExamGroupExam
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(){
        return $this->belongsTo('App\Exam','exam_id','id');
    }
}
