<?php

namespace App\Events;

use App\Models\Company;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CompanyBanned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Company $company;
    public string $why;
    public string $message;


    public function __construct($company, $why, $message) {
        $this->company = $company;
        $this->why = $why;
        $this->message = "Seu negócio '{$company->name}' foi banido da plataforma. Motivo: ${why}";
    }

    /**
     * Get the channel the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('company.'.$this->company->id);
    }
}

