<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'email',
        'password',
        'role',
        'image',
        'signature_image',
        'profile_completed_at',
        'mobile_verified_at',
        'validity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends=['image_path','full_name'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'profile_completed_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImagePathAttribute(){
        if($this->attributes['image']!=null){
            return url('/') .'/uploads/profiles/'.$this->attributes['image'];
        }else{
            return null;
        }
    }

    public function getFullNameAttribute(){
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function basics()
    {
        return $this->hasOne(BasicDetails::class, 'user_id', 'id');
    }

    public function presentAddress()
    {
        return $this->hasOne(Address::class, 'user_id', 'id')->where('type', 'present_address');
    }

    public function permanentAddress()
    {
        return $this->hasOne(Address::class, 'user_id', 'id')->where('type', 'permenant_address');
    }

    public function qualifications()
    {
        return $this->hasMany(CandidateQualification::class, 'user_id', 'id');
    }

    public function skills()
    {
        return $this->hasMany(CandidateSkill::class, 'user_id', 'id');
    }

    public function experiences()
    {
        return $this->hasMany(CandidateExperience::class, 'user_id', 'id');
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class, 'user_id', 'id');
    }

    public function backgroundQuestions()
    {
        return $this->hasMany(BackgroundQuestionAnswer::class, 'user_id', 'id');
    }

    public function basicDetails()
    {
        return $this->hasOne(BasicDetails::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function candidateQualifications()
    {
        return $this->hasMany(CandidateQualification::class, 'user_id', 'id');
    }

    public function candidateSkills()
    {
        return $this->hasMany(CandidateSkill::class, 'user_id', 'id');
    }

    public function candidateExperiences()
    {
        return $this->hasMany(CandidateExperience::class, 'user_id', 'id');
    }

    public function candidateHobby()
    {
        return $this->hasOne(CandidateHobby::class, 'user_id', 'id');
    }

    public function backgroundQuestionAnswers()
    {
        return $this->hasMany(BackgroundQuestionAnswer::class, 'user_id', 'id');
    }

    public function subscriptionPackage()
    {
        return $this->hasOne(PaymentHistory::class, 'user_id', 'id')
            ->where('status', 'completed')
            ->whereHas('package')
            ->latest();
    }

    public function activeSubscriptionPackage()
    {
        return $this->hasOne(PaymentHistory::class, 'user_id', 'id')
            ->where('status', 'completed')
            ->whereHas('package')
            ->whereHas('user', function ($query) {
                $query->whereNotNull('validity')->where('validity', '>', now());
            })
            ->latest();
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'user_id', 'id');
    }
}
