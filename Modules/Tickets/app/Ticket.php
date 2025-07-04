<?php

namespace Modules\Tickets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Tickets\Database\Factories\TicketFactory;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): TicketFactory
    {
        return TicketFactory::new();
    }

    protected $fillable = [
        'subject',
        'description',
        'priority',
    ];
}
