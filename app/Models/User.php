<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Utilities\CommonService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cookie;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    private $commonService;

    public function __construct()
    {
        $this->commonService = app()->make(\App\Utilities\CommonService::class);
    }

    public function loggable(): MorphTo
    {
        return $this->morphTo();

    }

    public function isAdmin() {

        return $this->loggable_type === Admin::class;

    }

    public function isInvitedUser() {

        return $this->loggable_type === InvitedUser::class;

    }

    public function isOwner() {

        return $this->loggable_type === Owner::class;

    }


    private function getShareNode($node)
    {

        $shareNode = null;

        $sharing = $this->commonService->getSharing();

        if ($sharing) {

            $shareNode = $sharing->role->sharedNode($node);

            $currentNode = $node;
            while (!$shareNode) {

                $shareNode = $sharing->role->sharedNode($currentNode->parent);
                $currentNode = $currentNode->parent;
            }
        }

        return $shareNode;

    }


    public function canRead($node) {

        if ($this->isOwner()) {
            return true;
        } elseif ($this->isInvitedUser())  {
            $sharedNode = $this->getShareNode($node);

            return $sharedNode?$sharedNode->can_read:false;
        }

    }

    public function canCreate($node) {

        if ($this->isOwner()) {
            return true;
        } elseif ($this->isInvitedUser())  {
            $sharedNode = $this->getShareNode($node);

            return $sharedNode?$sharedNode->can_create:false;
        }

    }

    public function canUpdate($node) {

        if ($this->isOwner()) {
            return true;
        } elseif ($this->isInvitedUser())  {
            $sharedNode = $this->getShareNode($node);

            return $sharedNode?$sharedNode->can_update:false;
        }

    }

    public function canDelete($node) {

        if ($this->isOwner()) {
            return true;
        } elseif ($this->isInvitedUser())  {
            $sharedNode = $this->getShareNode($node);

            return $sharedNode?$sharedNode->can_delete:false;
        }

    }

}
