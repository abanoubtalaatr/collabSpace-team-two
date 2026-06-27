<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasFiles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'job_title',
        'years_of_experience',
        'last_seen_at',
    ];


    public function isOnline(): bool
    {
        return $this->last_seen_at &&
            $this->last_seen_at->gt(
                now()->subMinutes(5)
            );
    }


    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants', 'user_id', 'conversation_id')
            ->withPivot('joined_at')
            ->withTimestamps();
    }

    public function createdConversations()
    {
        return $this->hasMany(Conversation::class, 'created_by');
    }


    public function conversationParticipants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messageReads()
    {
        return $this->hasMany(MessageRead::class);
    }

    public function messageMentions()
    {
        return $this->hasMany(MessageMention::class, 'mentioned_user_id');
    }

    public function createdProjects()
    {

        return $this->hasMany(Project::class, 'created_by');
    }




    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function createdMeetings()
    {
        return $this->hasMany(Meeting::class, 'creator_id');
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }



    // relationships: 
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id');
    }
}
