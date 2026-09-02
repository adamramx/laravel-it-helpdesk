<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'status',
    ];

    /**
     * User yang membuat ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Category ticket.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * IT Support yang ditugaskan.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    /**
     * Komentar pada ticket.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }
    public function activities(): HasMany
    {
        return $this->hasMany(TicketActivity::class);
    }
}