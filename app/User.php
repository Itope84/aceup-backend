<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const SUPER_TYPE = 'super';
    const EDITOR_TYPE = 'editor';
    const STUDENT_TYPE = 'student';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'department_id', 'gender', 'username', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function course_profiles()
    {
        return $this->hasMany('App\CourseProfile');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function slide_question_attempts()
    {
        return $this->hasMany('App\SlideQuestionAttempt');
    }

    public function quizzes()
    {
        return $this->hasMany('App\Quiz');
    }

    public function challenges_created()
    {
        return $this->hasMany('App\Challenge', 'challenger_id');
    }

    public function challenges_challenged()
    {
        return $this->hasMany('App\Challenge', 'opponent_id');
    }


    public function challenges()
    {
        return Challenge::where('challenger_id', $this->id)->orWhere('opponent_id', $this->id)->get();
    }

    // helpers
    public function is_super()
    {
        return $this->role === self::SUPER_TYPE;
    }

    public function is_privileged()
    {
        // Privileged users can use the admin dashboard
        return ($this->role === self::SUPER_TYPE || $this->role === self::EDITOR_TYPE);
    }
}
